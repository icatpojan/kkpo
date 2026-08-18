<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MasterNakes;

class MasterNakesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $nakes = MasterNakes::when($search, function ($query, $search) {
                        return $query->where('nama', 'like', "%{$search}%");
                    })
                    ->latest()
                    ->paginate(5);
        return view('master_nakes.index', compact('nakes', 'search'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'no_str' => 'nullable|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'no_wa' => 'nullable|string|max:255',
        ]);
        MasterNakes::create($data);
        return redirect()->route('master-nakes.index')->with('success', 'Data Nakes berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $nakes = MasterNakes::findOrFail($id);
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'no_str' => 'nullable|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'no_wa' => 'nullable|string|max:255',
        ]);
        $nakes->update($data);
        return redirect()->route('master-nakes.index')->with('success', 'Data Nakes berhasil diubah');
    }

    public function destroy($id)
    {
        MasterNakes::findOrFail($id)->delete();
        return redirect()->route('master-nakes.index')->with('success', 'Data Nakes berhasil dihapus');
    }
}
