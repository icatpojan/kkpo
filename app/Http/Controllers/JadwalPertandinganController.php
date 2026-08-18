<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalPertandingan;

class JadwalPertandinganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search'); // This is kept for backward compatibility if needed, but we'll use specific filters
        $filter_kegiatan = $request->query('filter_kegiatan');
        $filter_kelompok_cabor = $request->query('filter_kelompok_cabor');
        $filter_cabor = $request->query('filter_cabor');
        $filter_tanggal = $request->query('filter_tanggal');

        $jadwals = JadwalPertandingan::with(['kegiatan', 'nakesJagas.nakes'])
                    ->when($search, function ($query, $search) {
                        return $query->where('jenis_cabor', 'like', "%{$search}%");
                    })
                    ->when($filter_kegiatan, function ($query, $filter_kegiatan) {
                        return $query->whereHas('kegiatan', function($q) use ($filter_kegiatan) {
                            $q->where('nama_kegiatan', 'like', "%{$filter_kegiatan}%");
                        });
                    })
                    ->when($filter_kelompok_cabor, function ($query, $filter_kelompok_cabor) {
                        return $query->where('kel_cabor', $filter_kelompok_cabor);
                    })
                    ->when($filter_cabor, function ($query, $filter_cabor) {
                        return $query->where('jenis_cabor', $filter_cabor);
                    })
                    ->when($filter_tanggal, function ($query, $filter_tanggal) {
                        return $query->whereDate('tanggal', $filter_tanggal);
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
                    
        $kegiatans = \App\Kegiatan::orderBy('created_at', 'desc')->get();
        $kelompokCabors = \App\KelompokCabor::orderBy('nama')->get();
        $cabors = \App\Cabor::orderBy('nama')->get();
        $master_nakes = \App\MasterNakes::orderBy('nama')->get();
        
        return view('jadwal_pertandingan.index', compact('jadwals', 'search', 'kegiatans', 'filter_kegiatan', 'filter_kelompok_cabor', 'filter_cabor', 'filter_tanggal', 'kelompokCabors', 'cabors', 'master_nakes'));
    }

    public function create()
    {
        return view('jadwal_pertandingan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'jenis_cabor' => 'required|string',
            'kel_cabor' => 'nullable|string',
            'venue' => 'required|string',
            'alamat' => 'nullable|string',
            'link_google_map' => 'nullable|string',
            'jumlah_lapangan' => 'nullable|integer',
            'tanggal' => 'required|date',
            'waktu' => 'required|string',
            'nakes' => 'nullable|string',
        ]);
        \App\JadwalPertandingan::create($data);
        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = \App\JadwalPertandingan::findOrFail($id);
        return view('jadwal_pertandingan.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = \App\JadwalPertandingan::findOrFail($id);
        $data = $request->validate([
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'jenis_cabor' => 'required|string',
            'kel_cabor' => 'nullable|string',
            'venue' => 'required|string',
            'alamat' => 'nullable|string',
            'link_google_map' => 'nullable|string',
            'jumlah_lapangan' => 'nullable|integer',
            'tanggal' => 'required|date',
            'waktu' => 'required|string',
            'nakes' => 'nullable|string',
        ]);
        $jadwal->update($data);
        return redirect()->route('jadwal-pertandingan.index')->with('success', 'Jadwal berhasil diubah');
    }

    public function destroy($id)
    {
        \App\JadwalPertandingan::findOrFail($id)->delete();
        return redirect()->route('jadwal-pertandingan.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
