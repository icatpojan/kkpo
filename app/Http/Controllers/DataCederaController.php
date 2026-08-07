<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataCedera;

class DataCederaController extends Controller
{
    public function index()
    {
        $cederas = DataCedera::with('pelakuOlahraga')->where('status', '!=', 'rujuk')->get();
        return view('data_cedera.index', compact('cederas'));
    }

    public function rujukan()
    {
        $rujukans = DataCedera::with('pelakuOlahraga')->where('status', 'rujuk')->get();
        return view('data_cedera.rujukan', compact('rujukans'));
    }

    public function create($pelaku_id = null)
    {
        $pelakus = \App\PelakuOlahraga::all();
        return view('data_cedera.create', compact('pelakus', 'pelaku_id'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pelaku_olahraga_id' => 'required|exists:pelaku_olahragas,id',
            'waktu_kejadian' => 'required|date',
            'event' => 'nullable|string',
            'venue' => 'nullable|string',
            'bagian_cedera' => 'nullable|string',
            'kronologis' => 'nullable|string',
            'penanganan' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);
        $data['status'] = 'cedera';

        DataCedera::create($data);
        return redirect()->route('accident.cedera')->with('success', 'Data cedera berhasil dicatat');
    }

    public function rujuk($id)
    {
        $cedera = DataCedera::findOrFail($id);
        $cedera->update(['status' => 'rujuk']);
        return redirect()->route('accident.rujukan')->with('success', 'Pasien telah dirujuk');
    }

    public function sembuh($id)
    {
        $cedera = DataCedera::findOrFail($id);
        $cedera->update(['status' => 'sembuh']);
        return redirect()->route('accident.cedera')->with('success', 'Pasien telah dinyatakan sembuh');
    }
}
