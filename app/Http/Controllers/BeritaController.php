<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Berita;

class BeritaController extends Controller
{
    public function index()
    {
        $data = Berita::all();
        return view('manajemen.berita', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'tanggal_publikasi' => 'nullable|date',
        ]);
        Berita::create($validated);
        return redirect()->route('berita.index')->with('success', 'Berita berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'tanggal_publikasi' => 'nullable|date',
        ]);
        $berita->update($validated);
        return redirect()->route('berita.index')->with('success', 'Berita berhasil diubah');
    }

    public function destroy($id)
    {
        Berita::findOrFail($id)->delete();
        return redirect()->route('berita.index')->with('success', 'Berita berhasil dihapus');
    }
}
