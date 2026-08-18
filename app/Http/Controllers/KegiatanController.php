<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kegiatan;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $data = Kegiatan::with('jadwalPertandingans')->when($search, function ($query, $search) {
                        return $query->where('nama_kegiatan', 'like', "%{$search}%");
                    })
                    ->latest()
                    ->paginate(5);
                    
        $kelompokCabors = \App\KelompokCabor::orderBy('nama')->get();
        $cabors = \App\Cabor::orderBy('nama')->get();

        return view('manajemen.kegiatan', compact('data', 'search', 'kelompokCabors', 'cabors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_khusus' => 'required|boolean',
        ]);
        Kegiatan::create($validated);
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'is_khusus' => 'required|boolean',
        ]);
        $kegiatan->update($validated);
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diubah');
    }

    public function destroy($id)
    {
        Kegiatan::findOrFail($id)->delete();
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus');
    }
}
