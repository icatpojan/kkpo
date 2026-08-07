<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kegiatan;

class KegiatanController extends Controller
{
    public function index()
    {
        $data = Kegiatan::all();
        return view('manajemen.kegiatan', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);
        Kegiatan::create($validated);
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
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
