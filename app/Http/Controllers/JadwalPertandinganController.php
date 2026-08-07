<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JadwalPertandingan;

class JadwalPertandinganController extends Controller
{
    public function index()
    {
        $jadwals = \App\JadwalPertandingan::all();
        return view('jadwal_pertandingan.index', compact('jadwals'));
    }

    public function create()
    {
        return view('jadwal_pertandingan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis_cabor' => 'required|string',
            'kel_cabor' => 'nullable|string',
            'venue' => 'required|string',
            'jumlah_lapangan' => 'nullable|integer',
            'tanggal' => 'required|date',
            'waktu' => 'required|string',
            'nakes' => 'nullable|string',
        ]);
        \App\JadwalPertandingan::create($data);
        return redirect()->route('jadwal-pertandingan.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = \App\JadwalPertandingan::findOrFail($id);
        return view('jadwal_pertandingan.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = \App\JadwalPertandingan::findOrFail($id);
        $data = $request->validate([
            'jenis_cabor' => 'required|string',
            'kel_cabor' => 'nullable|string',
            'venue' => 'required|string',
            'jumlah_lapangan' => 'nullable|integer',
            'tanggal' => 'required|date',
            'waktu' => 'required|string',
            'nakes' => 'nullable|string',
        ]);
        $jadwal->update($data);
        return redirect()->route('jadwal-pertandingan.index')->with('success', 'Jadwal berhasil diubah');
    }

    public function destroy($id)
    {
        \App\JadwalPertandingan::findOrFail($id)->delete();
        return redirect()->route('jadwal-pertandingan.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
