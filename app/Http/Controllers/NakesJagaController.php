<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NakesJaga;

class NakesJagaController extends Controller
{
    public function index()
    {
        $nakes = \App\NakesJaga::with('nakes')->get();
        $master_nakes = \App\MasterNakes::all();
        return view('nakes_jaga.index', compact('nakes', 'master_nakes'));
    }

    public function create()
    {
        return view('nakes_jaga.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'cabor' => 'required|string',
            'venue' => 'required|string',
            'nakes_id' => 'required|exists:master_nakes,id',
            'personil' => 'nullable|string',
            'jumlah_cedera' => 'nullable|integer',
            'keterangan' => 'nullable|string',
            'upload_absen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'upload_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);
        
        if ($request->hasFile('upload_absen')) {
            $data['upload_absen'] = $request->file('upload_absen')->store('nakes_uploads', 'public');
        }
        if ($request->hasFile('upload_foto')) {
            $data['upload_foto'] = $request->file('upload_foto')->store('nakes_uploads', 'public');
        }

        \App\NakesJaga::create($data);
        return redirect()->route('nakes-jaga.index')->with('success', 'Nakes berhasil ditambahkan');
    }

    public function edit($id)
    {
        $nakes = \App\NakesJaga::findOrFail($id);
        $master_nakes = \App\MasterNakes::all();
        return view('nakes_jaga.edit', compact('nakes', 'master_nakes'));
    }

    public function update(Request $request, $id)
    {
        $nakes = \App\NakesJaga::findOrFail($id);
        $data = $request->validate([
            'tanggal' => 'required|date',
            'cabor' => 'required|string',
            'venue' => 'required|string',
            'nakes_id' => 'required|exists:master_nakes,id',
            'personil' => 'nullable|string',
            'jumlah_cedera' => 'nullable|integer',
            'keterangan' => 'nullable|string',
            'upload_absen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'upload_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('upload_absen')) {
            if ($nakes->upload_absen) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($nakes->upload_absen);
            }
            $data['upload_absen'] = $request->file('upload_absen')->store('nakes_uploads', 'public');
        }
        
        if ($request->hasFile('upload_foto')) {
            if ($nakes->upload_foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($nakes->upload_foto);
            }
            $data['upload_foto'] = $request->file('upload_foto')->store('nakes_uploads', 'public');
        }

        $nakes->update($data);
        return redirect()->route('nakes-jaga.index')->with('success', 'Data nakes berhasil diubah');
    }

    public function destroy($id)
    {
        \App\NakesJaga::findOrFail($id)->delete();
        return redirect()->route('nakes-jaga.index')->with('success', 'Data nakes dihapus');
    }
}
