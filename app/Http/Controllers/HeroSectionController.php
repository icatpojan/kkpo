<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HeroSection;
use Illuminate\Support\Facades\Storage;

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
        ]);

        $hero = HeroSection::first();
        if (!$hero) {
            $hero = new HeroSection();
        }

        $hero->judul = $request->judul;
        $hero->sub_judul = $request->sub_judul;

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($hero->gambar && Storage::disk('public')->exists($hero->gambar)) {
                Storage::disk('public')->delete($hero->gambar);
            }
            // Store new image
            $path = $request->file('gambar')->store('hero', 'public');
            $hero->gambar = $path;
        }

        $hero->save();

        return redirect()->route('hero.index')->with('success', 'Pengaturan Hero berhasil diperbarui');
    }
}
