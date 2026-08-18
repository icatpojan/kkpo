<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StrukturOrganisasi;
use Illuminate\Support\Facades\File;

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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pengurus'), $filename);
            $validated['gambar'] = 'uploads/pengurus/' . $filename;
        }

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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('gambar')) {
            // Delete old file
            if ($struktur->gambar && File::exists(public_path($struktur->gambar))) {
                File::delete(public_path($struktur->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/pengurus'), $filename);
            $validated['gambar'] = 'uploads/pengurus/' . $filename;
        }

        $struktur->update($validated);
        return redirect()->route('struktur.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $struktur = StrukturOrganisasi::findOrFail($id);
        if ($struktur->gambar && File::exists(public_path($struktur->gambar))) {
            File::delete(public_path($struktur->gambar));
        }
        $struktur->delete();
        return redirect()->route('struktur.index')->with('success', 'Data berhasil dihapus');
    }
}
