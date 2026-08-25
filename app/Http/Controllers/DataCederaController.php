<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataCedera;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class DataCederaController extends Controller
{
    private function getFilterLists()
    {
        $kegiatans = \App\Kegiatan::all();
        $listCaborRaw = [];
        foreach(\App\Cabor::all() as $c) {
            $listCaborRaw[$c->kelompok_kode][$c->kode] = $c->nama;
        }
        $listCabor = [];
        if ($listCaborRaw) {
            foreach ($listCaborRaw as $group => $cabors) {
                foreach ($cabors as $code => $name) {
                    $listCabor[] = $name;
                }
            }
        }
        $listCabor = array_unique($listCabor);
        sort($listCabor);
        $pelakus = \App\PelakuOlahraga::orderBy('nama', 'asc')->get();

        return compact('kegiatans', 'listCabor', 'pelakus');
    }

    private function applyFilters($query, Request $request)
    {
        $search = $request->query('search'); // Nama orang
        $cabor = $request->query('cabor');
        $kegiatan_id = $request->query('kegiatan_id');
        $rs_rujukan = $request->query('rs_rujukan');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $status = $request->query('status');

        if (auth()->check()) {
            if (auth()->user()->role === 'rs') {
                $query->where('rs_rujukan', auth()->user()->name);
            } elseif (auth()->user()->role === 'koni') {
                $query->whereHas('pelakuOlahraga', function ($q) {
                    $q->where('kontingen', auth()->user()->name);
                });
            }
        }

        if ($search || $cabor) {
            $query->whereHas('pelakuOlahraga', function ($q) use ($search, $cabor) {
                if ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                }
                if ($cabor) {
                    $q->where('cabor', $cabor);
                }
            });
        }

        if ($kegiatan_id) {
            $query->whereHas('nakesJaga.jadwalPertandingan', function ($q) use ($kegiatan_id) {
                $q->where('kegiatan_id', $kegiatan_id);
            });
        }

        if ($rs_rujukan) {
            $query->where('rs_rujukan', 'like', "%{$rs_rujukan}%");
        }

        if ($start_date) {
            $query->whereDate('waktu_kejadian', '>=', $start_date);
        }

        if ($end_date) {
            $query->whereDate('waktu_kejadian', '<=', $end_date);
        }

        if ($status) {
            $query->where('status', $status);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $query = \App\DataCedera::with(['pelakuOlahraga.dokumens', 'images', 'riwayatPerawatans']);
        
        $query = $this->applyFilters($query, $request);
        
        $cederas = $query->orderBy('created_at', 'desc')->paginate(10);
        $filters = $this->getFilterLists();
        return view('data_cedera.index', array_merge(compact('cederas'), $filters));
    }

    public function create($pelaku_id = null)
    {
        $pelakus = \App\PelakuOlahraga::all();
        $jadwals = \App\JadwalPertandingan::all();
        $nakesJagas = \App\NakesJaga::all();
        return view('data_cedera.create', compact('pelakus', 'pelaku_id', 'jadwals', 'nakesJagas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pelaku_olahraga_id' => 'required|exists:pelaku_olahragas,id',
            'jadwal_pertandingan_id' => 'required|exists:jadwal_pertandingans,id',
            'waktu_kejadian' => 'required|date',
            'bagian_cedera' => 'nullable|string',
            'kronologis' => 'nullable|string',
            'penanganan' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        
        if (auth()->user()->role === 'rs') {
            $data['status'] = 'rujuk';
            $data['rs_rujukan'] = auth()->user()->name;
        } else {
            $data['status'] = 'cedera';
        }

        $jadwal = \App\JadwalPertandingan::find($data['jadwal_pertandingan_id']);
        if ($jadwal) {
            $nakesJaga = $jadwal->nakesJagas()->first();
            $data['nakes_jaga_id'] = $nakesJaga ? $nakesJaga->id : null;
        }

        $foto = null;
        if (isset($data['foto'])) {
            $foto = $data['foto'];
            unset($data['foto']);
        }

        $dataCedera = \App\DataCedera::create($data);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('insiden', $filename, 'public');
            
            \App\DataCederaImage::create([
                'data_cedera_id' => $dataCedera->id,
                'image_path' => 'insiden/' . $filename
            ]);
        }

        return redirect()->route('accident.cedera')->with('success', 'Data cedera berhasil dicatat');
    }

    public function rujuk(Request $request, $id)
    {
        $cedera = \App\DataCedera::findOrFail($id);
        if (auth()->user()->role === 'rs' && $cedera->rs_rujukan !== auth()->user()->name) abort(403);
        if (auth()->user()->role === 'koni' && $cedera->pelakuOlahraga->kontingen !== auth()->user()->name) abort(403);
        
        $cedera->update([
            'status' => 'rujuk',
            'rs_rujukan' => $request->rs_rujukan,
            'keterangan' => $request->keterangan ?? $cedera->keterangan
        ]);
        return redirect()->route('accident.cedera')->with('success', 'Pasien telah dirujuk');
    }

    public function sembuh(Request $request, $id)
    {
        $cedera = \App\DataCedera::findOrFail($id);
        if (auth()->user()->role === 'rs' && $cedera->rs_rujukan !== auth()->user()->name) abort(403);
        if (auth()->user()->role === 'koni' && $cedera->pelakuOlahraga->kontingen !== auth()->user()->name) abort(403);
        
        $data = $request->validate([
            'tanggal_waktu' => 'required|date',
            'tindakan' => 'required|string',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/perawatan_images'), $filename);
            $data['foto'] = 'uploads/perawatan_images/' . $filename;
        }

        $cedera->riwayatPerawatans()->create($data);
        $cedera->update(['status' => 'sembuh']);
        
        return redirect()->route('accident.cedera')->with('success', 'Pasien telah dinyatakan sembuh beserta catatan perawatannya');
    }
    public function storePerawatan(Request $request, $id)
    {
        $cedera = \App\DataCedera::findOrFail($id);
        if (auth()->user()->role === 'rs' && $cedera->rs_rujukan !== auth()->user()->name) abort(403);
        if (auth()->user()->role === 'koni' && $cedera->pelakuOlahraga->kontingen !== auth()->user()->name) abort(403);
        $data = $request->validate([
            'tanggal_waktu' => 'required|date',
            'tindakan' => 'required|string',
            'keterangan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/perawatan_images'), $filename);
            $data['foto'] = 'uploads/perawatan_images/' . $filename;
        }

        $cedera->riwayatPerawatans()->create($data);
        
        if ($request->input('action') === 'simpan_dan_sembuh') {
            $cedera->update(['status' => 'sembuh']);
            return redirect()->back()->with('success', 'Riwayat perawatan berhasil ditambahkan dan pasien dinyatakan sembuh');
        }
        
        return redirect()->back()->with('success', 'Riwayat perawatan berhasil ditambahkan');
    }

    private function preparePdfData($id)
    {
        $cedera = \App\DataCedera::with(['pelakuOlahraga', 'nakesJaga.jadwalPertandingan.kegiatan'])->findOrFail($id);
        if (auth()->user()->role === 'rs' && $cedera->rs_rujukan !== auth()->user()->name) abort(403);
        if (auth()->user()->role === 'koni' && $cedera->pelakuOlahraga->kontingen !== auth()->user()->name) abort(403);
        
        $pelaku = $cedera->pelakuOlahraga;
        
        $kegiatan_nama = 'VENUE';
        if ($cedera->jadwalPertandingan && $cedera->jadwalPertandingan->kegiatan) {
            $kegiatan_nama = $cedera->jadwalPertandingan->kegiatan->nama_kegiatan;
        }

        $tanggal_kejadian = $cedera->waktu_kejadian ? Carbon::parse($cedera->waktu_kejadian)->format('d/m/Y') : '-';
        $jam_kejadian = $cedera->waktu_kejadian ? Carbon::parse($cedera->waktu_kejadian)->format('H:i') : '-';

        return compact('cedera', 'pelaku', 'kegiatan_nama', 'tanggal_kejadian', 'jam_kejadian');
    }

    public function printTahap1($id)
    {
        $data = $this->preparePdfData($id);
        $pdf = PDF::loadView('data_cedera.pdf_tahap1', $data);
        return $pdf->stream('Form_3_KK_1_Tahap_I_' . $data['pelaku']->nama . '.pdf');
    }

    public function printTahap2($id)
    {
        $data = $this->preparePdfData($id);
        $pdf = PDF::loadView('data_cedera.pdf_tahap2', $data);
        return $pdf->stream('Form_3a_KK_2_Tahap_II_' . $data['pelaku']->nama . '.pdf');
    }

    public function printKronologis($id)
    {
        $data = $this->preparePdfData($id);
        
        $hari_kejadian = '-';
        if ($data['cedera']->waktu_kejadian) {
            Carbon::setLocale('id');
            $hari_kejadian = Carbon::parse($data['cedera']->waktu_kejadian)->translatedFormat('l');
        }
        
        $data['hari_kejadian'] = $hari_kejadian;
        
        $pdf = PDF::loadView('data_cedera.pdf_kronologis', $data);
        return $pdf->stream('Form_3_Berita_Acara_Kronologis_' . $data['pelaku']->nama . '.pdf');
    }

    public function printFoto($id)
    {
        $cedera = \App\DataCedera::with(['pelakuOlahraga', 'images', 'riwayatPerawatans'])->findOrFail($id);
        if (auth()->user()->role === 'rs' && $cedera->rs_rujukan !== auth()->user()->name) abort(403);
        if (auth()->user()->role === 'koni' && $cedera->pelakuOlahraga->kontingen !== auth()->user()->name) abort(403);
        
        $pdf = PDF::loadView('data_cedera.pdf_foto', compact('cedera'));
        return $pdf->stream('Laporan_Foto_Perawatan_' . ($cedera->pelakuOlahraga->nama ?? 'Pasien') . '.pdf');
    }
}
