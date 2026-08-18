<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kegiatan;
use App\JadwalPertandingan;
use App\PelakuOlahraga;
use App\DataCedera;
use App\DataCederaImage;
use Carbon\Carbon;

class LaporInsidenController extends Controller
{
    public function index(Request $request)
    {
        $kegiatans = Kegiatan::orderBy('tanggal', 'desc')->get();
        
        $jadwals = [];
        if ($request->kegiatan_id) {
            $jadwals = JadwalPertandingan::where('kegiatan_id', $request->kegiatan_id)->get();
        }
        
        // We fetch atlit dynamically or pass all (might be too large, but for now it's okay)
        // Usually better with AJAX, but let's pass it for simple form.
        $atlits = PelakuOlahraga::where('kategori', 'atlit')->orderBy('nama')->get();

        return view('lapor_insiden.index', compact('kegiatans', 'jadwals', 'atlits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelaku_olahraga_id' => 'required|exists:pelaku_olahragas,id',
            'waktu_kejadian' => 'required|date',
            'jadwal_pertandingan_id' => 'required|exists:jadwal_pertandingans,id',
            'bagian_cedera' => 'required|string|max:255',
            'penanganan' => 'nullable|string',
            'kronologis' => 'required|string',
            'keterangan' => 'nullable|string',
            'foto_base64' => 'nullable|string'
        ]);

        $jadwal = \App\JadwalPertandingan::find($validated['jadwal_pertandingan_id']);
        $nakesJagaId = null;
        if ($jadwal) {
            $nakesJaga = $jadwal->nakesJagas()->first();
            $nakesJagaId = $nakesJaga ? $nakesJaga->id : null;
        }

        $dataCedera = DataCedera::create([
            'pelaku_olahraga_id' => $validated['pelaku_olahraga_id'],
            'waktu_kejadian' => $validated['waktu_kejadian'],
            'jadwal_pertandingan_id' => $validated['jadwal_pertandingan_id'],
            'nakes_jaga_id' => $nakesJagaId,
            'bagian_cedera' => $validated['bagian_cedera'],
            'penanganan' => $validated['penanganan'] ?? null,
            'kronologis' => $validated['kronologis'],
            'keterangan' => $validated['keterangan'] ?? null,
            'status' => 'cedera', // default pending/cedera
        ]);

        if ($request->filled('foto_base64')) {
            $fotoBase64 = str_replace(' ', '+', $request->input('foto_base64'));
            list($type, $fotoBase64) = explode(';', $fotoBase64);
            list(, $fotoBase64)      = explode(',', $fotoBase64);
            $fotoData = base64_decode($fotoBase64);
            $imageName = 'insiden_'.time().'.jpg';
            \Storage::disk('public')->put('insiden/'.$imageName, $fotoData);
            
            DataCederaImage::create([
                'data_cedera_id' => $dataCedera->id,
                'image_path' => 'insiden/'.$imageName
            ]);
        }
        return redirect('/')->with('success_lapor', 'Laporan cedera berhasil dikirim. Tim medis KKPO akan segera menindaklanjutinya.');
    }

    public function success()
    {
        return view('lapor_insiden.success');
    }
}
