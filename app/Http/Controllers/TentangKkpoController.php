<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TentangKkpo;

class TentangKkpoController extends Controller
{
    public function index()
    {
        $data = TentangKkpo::all();
        return view('manajemen.tentang', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
        ]);
        TentangKkpo::create($validated);
        return redirect()->route('tentang.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $tentang = TentangKkpo::findOrFail($id);
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
        ]);
        $tentang->update($validated);
        return redirect()->route('tentang.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        TentangKkpo::findOrFail($id)->delete();
        return redirect()->route('tentang.index')->with('success', 'Data berhasil dihapus');
    }
}
