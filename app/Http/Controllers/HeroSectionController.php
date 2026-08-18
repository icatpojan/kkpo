<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HeroSection;
use Illuminate\Support\Facades\File;

class HeroSectionController extends Controller
{
    public function index()
    {
        // Get the first hero section, or create an empty instance if it doesn't exist
        $hero = HeroSection::first() ?? new HeroSection();
        return view('manajemen.hero', compact('hero'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'sub_judul' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4048',
        ], [
            'gambar.image' => 'File yang diupload harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa jpeg, png, jpg, gif, svg, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal adalah 4MB.',
            'gambar.uploaded' => 'Gagal mengupload gambar. Pastikan ukuran gambar tidak terlalu besar (maksimal 2MB - 4MB sesuai pengaturan server) dan koneksi stabil.',
        ]);

        $hero = HeroSection::first();
        if (!$hero) {
            $hero = new HeroSection();
        }

        $hero->judul = $request->judul;
        $hero->sub_judul = $request->sub_judul;

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($hero->gambar && File::exists(public_path($hero->gambar))) {
                File::delete(public_path($hero->gambar));
            }
            // Store new image
            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/hero'), $filename);
            $hero->gambar = 'uploads/hero/' . $filename;
        }

        $hero->save();

        return redirect()->route('hero.index')->with('success', 'Pengaturan Hero berhasil diperbarui');
    }
}
