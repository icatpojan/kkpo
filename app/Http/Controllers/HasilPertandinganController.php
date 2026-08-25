<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HasilPertandingan;
use App\Kegiatan;
use App\Cabor;
use App\Kota;
use App\PelakuOlahraga;

class HasilPertandinganController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $search = $request->query('search');
        $kegiatan_id = $request->query('kegiatan_id');
        $cabor = $request->query('cabor');

        $query = HasilPertandingan::with(['kegiatan', 'emasPelaku', 'perakPelaku', 'perungguPelaku'])
            ->latest();

        if ($kegiatan_id) {
            $query->where('kegiatan_id', $kegiatan_id);
        }

        if ($cabor) {
            $query->where('cabor', $cabor);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('cabor', 'like', "%{$search}%")
                  ->orWhere('emas_kontingen', 'like', "%{$search}%")
                  ->orWhere('perak_kontingen', 'like', "%{$search}%")
                  ->orWhere('perunggu_kontingen', 'like', "%{$search}%")
                  ->orWhereHas('emasPelaku', function ($sub) use ($search) {
                      $sub->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('perakPelaku', function ($sub) use ($search) {
                      $sub->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('perungguPelaku', function ($sub) use ($search) {
                      $sub->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        $hasilPertandingans = $query->paginate(15);
        $kegiatans = Kegiatan::where('is_khusus', false)->orderBy('tanggal_mulai', 'desc')->get();
        $cabors = Cabor::orderBy('nama')->get();
        $kotas = Kota::orderBy('nama')->get();
        $atlits = PelakuOlahraga::where('kategori', 'atlit')->orderBy('nama')->get();

        // Hitung klasemen medali
        $medaliData = HasilPertandingan::getKlasemenMedali($kegiatan_id);

        return view('hasil_pertandingan.index', compact(
            'hasilPertandingans',
            'kegiatans',
            'cabors',
            'kotas',
            'atlits',
            'search',
            'kegiatan_id',
            'cabor',
            'medaliData'
        ));
    }

    public function create()
    {
        return redirect()->route('hasil-pertandingan.index');
    }

    public function edit($id)
    {
        return redirect()->route('hasil-pertandingan.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'cabor' => 'required|string|max:255',
            
            // Emas
            'emas_pelaku_id' => 'nullable|exists:pelaku_olahragas,id',
            'emas_kontingen' => 'nullable|string|max:255',
            
            // Perak
            'perak_pelaku_id' => 'nullable|exists:pelaku_olahragas,id',
            'perak_kontingen' => 'nullable|string|max:255',
            
            // Perunggu
            'perunggu_pelaku_id' => 'nullable|exists:pelaku_olahragas,id',
            'perunggu_kontingen' => 'nullable|string|max:255',
        ]);

        // Auto-detect kontingen dari atlet jika belum diisi manual
        if (!empty($data['emas_pelaku_id']) && empty($data['emas_kontingen'])) {
            $atlet = PelakuOlahraga::find($data['emas_pelaku_id']);
            $data['emas_kontingen'] = $atlet ? $atlet->kontingen : null;
        }

        if (!empty($data['perak_pelaku_id']) && empty($data['perak_kontingen'])) {
            $atlet = PelakuOlahraga::find($data['perak_pelaku_id']);
            $data['perak_kontingen'] = $atlet ? $atlet->kontingen : null;
        }

        if (!empty($data['perunggu_pelaku_id']) && empty($data['perunggu_kontingen'])) {
            $atlet = PelakuOlahraga::find($data['perunggu_pelaku_id']);
            $data['perunggu_kontingen'] = $atlet ? $atlet->kontingen : null;
        }

        HasilPertandingan::create($data);

        return redirect()->route('hasil-pertandingan.index')->with('success', 'Hasil pertandingan & medali berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $hasil = HasilPertandingan::findOrFail($id);

        $data = $request->validate([
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'cabor' => 'required|string|max:255',
            
            // Emas
            'emas_pelaku_id' => 'nullable|exists:pelaku_olahragas,id',
            'emas_kontingen' => 'nullable|string|max:255',
            
            // Perak
            'perak_pelaku_id' => 'nullable|exists:pelaku_olahragas,id',
            'perak_kontingen' => 'nullable|string|max:255',
            
            // Perunggu
            'perunggu_pelaku_id' => 'nullable|exists:pelaku_olahragas,id',
            'perunggu_kontingen' => 'nullable|string|max:255',
        ]);

        if (!empty($data['emas_pelaku_id']) && empty($data['emas_kontingen'])) {
            $atlet = PelakuOlahraga::find($data['emas_pelaku_id']);
            $data['emas_kontingen'] = $atlet ? $atlet->kontingen : null;
        }

        if (!empty($data['perak_pelaku_id']) && empty($data['perak_kontingen'])) {
            $atlet = PelakuOlahraga::find($data['perak_pelaku_id']);
            $data['perak_kontingen'] = $atlet ? $atlet->kontingen : null;
        }

        if (!empty($data['perunggu_pelaku_id']) && empty($data['perunggu_kontingen'])) {
            $atlet = PelakuOlahraga::find($data['perunggu_pelaku_id']);
            $data['perunggu_kontingen'] = $atlet ? $atlet->kontingen : null;
        }

        $hasil->update($data);

        return redirect()->route('hasil-pertandingan.index')->with('success', 'Hasil pertandingan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $hasil = HasilPertandingan::findOrFail($id);
        $hasil->delete();

        return redirect()->route('hasil-pertandingan.index')->with('success', 'Hasil pertandingan berhasil dihapus!');
    }
}
