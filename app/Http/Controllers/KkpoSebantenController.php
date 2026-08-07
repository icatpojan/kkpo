<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KkpoSebanten;

class KkpoSebantenController extends Controller
{
    public function index()
    {
        $data = \App\KkpoSebanten::all();
        return view('kkpo_sebanten.index', compact('data'));
    }

    public function create()
    {
        return view('kkpo_sebanten.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wadah' => 'required|string',
            'nama_personil' => 'required|string',
            'npp' => 'nullable|string',
            'alamat_kantor' => 'nullable|string',
        ]);
        \App\KkpoSebanten::create($validated);
        return redirect()->route('kkpo-sebanten.index')->with('success', 'Data ditambahkan');
    }

    public function edit($id)
    {
        $kkpo = \App\KkpoSebanten::findOrFail($id);
        return view('kkpo_sebanten.edit', compact('kkpo'));
    }

    public function update(Request $request, $id)
    {
        $kkpo = \App\KkpoSebanten::findOrFail($id);
        $validated = $request->validate([
            'wadah' => 'required|string',
            'nama_personil' => 'required|string',
            'npp' => 'nullable|string',
            'alamat_kantor' => 'nullable|string',
        ]);
        $kkpo->update($validated);
        return redirect()->route('kkpo-sebanten.index')->with('success', 'Data diubah');
    }

    public function destroy($id)
    {
        \App\KkpoSebanten::findOrFail($id)->delete();
        return redirect()->route('kkpo-sebanten.index')->with('success', 'Data dihapus');
    }
}
