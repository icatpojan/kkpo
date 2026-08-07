<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PelakuOlahraga;

class PelakuOlahragaController extends Controller
{
    public function index($kategori)
    {
        $pelakus = PelakuOlahraga::where('kategori', $kategori)->get();
        return view('pelaku_olahraga.index', compact('pelakus', 'kategori'));
    }

    public function create($kategori)
    {
        return view('pelaku_olahraga.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori' => 'required|in:atlit,pelatih,official,koni',
            'nama' => 'required|string',
            'jk' => 'required|in:L,P',
            'ttl' => 'nullable|string',
            'nik' => 'nullable|string',
            'no_wa' => 'nullable|string',
            'cabor' => 'nullable|string',
            'kel_cabor' => 'nullable|string',
            'kontingen' => 'nullable|string',
            'alamat' => 'nullable|string',
            'riwayat_kesehatan' => 'nullable|string',
            'bagian' => 'nullable|string',
            'koni' => 'nullable|string',
        ]);

        PelakuOlahraga::create($data);
        return redirect()->route('pelaku.index', $request->kategori)->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pelaku = PelakuOlahraga::findOrFail($id);
        $kategori = $pelaku->kategori;
        return view('pelaku_olahraga.edit', compact('pelaku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $pelaku = PelakuOlahraga::findOrFail($id);
        $data = $request->validate([
            'nama' => 'required|string',
            'jk' => 'required|in:L,P',
            'ttl' => 'nullable|string',
            'nik' => 'nullable|string',
            'no_wa' => 'nullable|string',
            'cabor' => 'nullable|string',
            'kel_cabor' => 'nullable|string',
            'kontingen' => 'nullable|string',
            'alamat' => 'nullable|string',
            'riwayat_kesehatan' => 'nullable|string',
            'bagian' => 'nullable|string',
            'koni' => 'nullable|string',
        ]);

        $pelaku->update($data);
        return redirect()->route('pelaku.index', $pelaku->kategori)->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $pelaku = PelakuOlahraga::findOrFail($id);
        $kategori = $pelaku->kategori;
        $pelaku->delete();
        return redirect()->route('pelaku.index', $kategori)->with('success', 'Data berhasil dihapus');
    }
}
