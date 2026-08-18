<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NakesJaga;

class NakesJagaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $nakes = \App\NakesJaga::with(['nakes', 'absens'])
                    ->whereHas('nakes', function ($query) use ($search) {
                        $query->when($search, function ($q, $search) {
                            $q->where('nama', 'like', "%{$search}%");
                        });
                    })
                    ->orWhere('personil', 'like', "%{$search}%")
                    ->latest()
                    ->paginate(15);
        $master_nakes = \App\MasterNakes::all();
        $listKelompok = \App\KelompokCabor::pluck('nama', 'kode')->toArray();
        $listCabor = [];
        foreach(\App\Cabor::all() as $c) {
            $listCabor[$c->kelompok_kode][$c->kode] = $c->nama;
        }
        $jadwals = \App\JadwalPertandingan::with('kegiatan')->orderBy('tanggal', 'desc')->get();
        return view('nakes_jaga.index', compact('nakes', 'master_nakes', 'search', 'listKelompok', 'listCabor', 'jadwals'));
    }

    public function create()
    {
        return view('nakes_jaga.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jadwal_pertandingan_id' => 'required|exists:jadwal_pertandingans,id',
            'nakes_id' => 'required|exists:master_nakes,id',
            'instansi' => 'nullable|string',
            'lini1' => 'nullable|string',
            'lini2' => 'nullable|string',
            'lini3' => 'nullable|string',
        ]);
        
        $jadwal = \App\JadwalPertandingan::find($data['jadwal_pertandingan_id']);
        $data['tanggal'] = $jadwal->tanggal;
        $data['cabor'] = $jadwal->jenis_cabor;
        $data['venue'] = $jadwal->venue;
        
        \App\NakesJaga::create($data);
        return redirect()->back()->with('success', 'Nakes berhasil ditambahkan');
    }

    public function edit($id)
    {
        $nakes = \App\NakesJaga::findOrFail($id);
        $master_nakes = \App\MasterNakes::all();
        return view('nakes_jaga.edit', compact('nakes', 'master_nakes'));
    }

    public function update(Request $request, $id)
    {
        $nakes = \App\NakesJaga::findOrFail($id);
        $data = $request->validate([
            'jadwal_pertandingan_id' => 'required|exists:jadwal_pertandingans,id',
            'nakes_id' => 'required|exists:master_nakes,id',
            'instansi' => 'nullable|string',
            'lini1' => 'nullable|string',
            'lini2' => 'nullable|string',
            'lini3' => 'nullable|string',
        ]);

        $jadwal = \App\JadwalPertandingan::find($data['jadwal_pertandingan_id']);
        $data['tanggal'] = $jadwal->tanggal;
        $data['cabor'] = $jadwal->jenis_cabor;
        $data['venue'] = $jadwal->venue;

        $nakes->update($data);
        return redirect()->back()->with('success', 'Data nakes berhasil diubah');
    }

    public function destroy($id)
    {
        \App\NakesJaga::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data nakes dihapus');
    }

    public function storeAbsen(Request $request, $id)
    {
        $nakesJaga = \App\NakesJaga::findOrFail($id);
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'bank' => 'nullable|string|max:100',
            'norek' => 'nullable|string|max:100',
            'foto_base64' => 'nullable|string',
            'tanda_tangan_base64' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'tanda_tangan' => 'nullable|image|max:2048',
        ]);

        // Process Foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('nakes_absens', 'public');
        } elseif ($request->foto_base64) {
            $fotoBase64 = str_replace(' ', '+', $request->foto_base64);
            $image_parts = explode(";base64,", $fotoBase64);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            
            $fileName = uniqid() . '.png';
            $filePath = 'nakes_absens/' . $fileName;
            
            \Illuminate\Support\Facades\Storage::disk('public')->put($filePath, $image_base64);
            $data['foto'] = $filePath;
        }

        // Process Tanda Tangan
        if ($request->hasFile('tanda_tangan')) {
            $data['tanda_tangan'] = $request->file('tanda_tangan')->store('nakes_absens', 'public');
        } elseif ($request->tanda_tangan_base64) {
            $ttdBase64 = str_replace(' ', '+', $request->tanda_tangan_base64);
            $ttd_parts = explode(";base64,", $ttdBase64);
            $ttd_base64_decoded = base64_decode($ttd_parts[1]);
            
            $ttdFileName = 'ttd_' . uniqid() . '.png';
            $ttdFilePath = 'nakes_absens/' . $ttdFileName;
            
            \Illuminate\Support\Facades\Storage::disk('public')->put($ttdFilePath, $ttd_base64_decoded);
            $data['tanda_tangan'] = $ttdFilePath;
        }

        unset($data['foto_base64']);
        unset($data['tanda_tangan_base64']);

        $nakesJaga->absens()->create($data);
        return redirect()->back()->with('success', 'Absensi berhasil ditambahkan.');
    }

    public function destroyAbsen($id)
    {
        $absen = \App\NakesJagaAbsen::findOrFail($id);
        if ($absen->foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($absen->foto);
        }
        $absen->delete();
        return redirect()->back()->with('success', 'Absensi berhasil dihapus.');
    }
}
