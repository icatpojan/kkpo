<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StrukturOrganisasi;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $data = StrukturOrganisasi::all();
        return view('manajemen.struktur', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);
        StrukturOrganisasi::create($validated);
        return redirect()->route('struktur.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $struktur = StrukturOrganisasi::findOrFail($id);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);
        $struktur->update($validated);
        return redirect()->route('struktur.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        StrukturOrganisasi::findOrFail($id)->delete();
        return redirect()->route('struktur.index')->with('success', 'Data berhasil dihapus');
    }
}
