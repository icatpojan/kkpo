<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PelakuOlahraga;
use Illuminate\Support\Facades\File;

class PelakuOlahragaController extends Controller
{
    public function index(Request $request, $kategori)
    {
        $search = $request->query('search');
        $cabor = $request->query('cabor');
        $kel_cabor = $request->query('kel_cabor');
        $jk = $request->query('jk');
        $kontingen = $request->query('kontingen');

        $listKelompok = \App\KelompokCabor::pluck('nama', 'kode')->toArray();
        $listKota = \App\Kota::pluck('nama', 'kode')->toArray();
        $listCabor = [];
        foreach(\App\Cabor::orderBy('nama', 'asc')->get() as $c) {
            $listCabor[$c->kelompok_kode][] = $c->nama;
        }

        $pelakus = PelakuOlahraga::with(['dataCederas.riwayatPerawatans', 'dokumens'])
                    ->where('kategori', $kategori)
                    ->when(auth()->user()->role === 'koni', function ($query) {
                        return $query->where('kontingen', auth()->user()->name);
                    })
                    ->when($search, function ($query, $search) {
                        return $query->where('nama', 'like', "%{$search}%");
                    })
                    ->when($kel_cabor, function ($query, $kel_cabor) {
                        $namaKelompok = \App\KelompokCabor::where('kode', $kel_cabor)->value('nama');
                        return $query->where('kel_cabor', $namaKelompok ?? $kel_cabor);
                    })
                    ->when($cabor, function ($query, $cabor) {
                        return $query->where('cabor', $cabor);
                    })
                    ->when($jk, function ($query, $jk) {
                        return $query->where('jk', $jk);
                    })
                    ->when($kontingen, function ($query, $kontingen) {
                        return $query->where('kontingen', $kontingen);
                    })
                    ->latest()
                    ->paginate(5);
        return view('pelaku_olahraga.index', compact('pelakus', 'kategori', 'search', 'cabor', 'kel_cabor', 'jk', 'kontingen', 'listCabor', 'listKelompok', 'listKota'));
    }

    public function create($kategori)
    {
        return view('pelaku_olahraga.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori' => 'required|in:atlit,pelatih,official,koni',
            'nama' => 'required|string',
            'jk' => 'required|in:L,P',
            'ttl' => 'nullable|string',
            'nik' => 'nullable|string',
            'no_wa' => 'nullable|string',
            'cabor' => 'nullable|string',
            'kel_cabor' => 'nullable|string',
            'kontingen' => 'nullable|string',
            'alamat' => 'nullable|string',
            'riwayat_kesehatan' => 'nullable|string',
            'bagian' => 'nullable|string',
            'koni' => 'nullable|string',
            'dokumen.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ]);

        $dokumens = null;
        if ($request->hasFile('dokumen')) {
            $dokumens = $request->file('dokumen');
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/foto_atlet'), $filename);
            $data['foto'] = 'uploads/foto_atlet/' . $filename;
        }

        if ($request->kategori != 'koni') {
            $prefixKategori = strtoupper($request->kategori);
            $kodeKelompok = $request->kel_cabor;
            $kodeCabor = '';
            
            $cabor = \App\Cabor::where('kelompok_kode', $kodeKelompok)->where('nama', $request->cabor)->first();
            if ($cabor) {
                $kodeCabor = $cabor->kode;
            }
            
            $kodeKota = '';
            $kota = \App\Kota::where('nama', $request->kontingen)->first();
            if ($kota) {
                $kodeKota = $kota->kode;
            }
            
            if ($kodeKelompok && $kodeCabor && $kodeKota) {
                $prefix = $prefixKategori . ' ' . $kodeKelompok . $kodeCabor . '-' . $kodeKota . '-';
                $latest = PelakuOlahraga::where('nomor_anggota', 'like', $prefix . '%')
                            ->orderBy('nomor_anggota', 'desc')
                            ->first();
                if ($latest && preg_match('/-(\d+)$/', $latest->nomor_anggota, $matches)) {
                    $nextUrut = intval($matches[1]) + 1;
                } else {
                    $nextUrut = 1;
                }
                $data['nomor_anggota'] = $prefix . str_pad($nextUrut, 4, '0', STR_PAD_LEFT);
            }
        } else {
            // Kategori KONI
            $prefix = 'KONI ' . date('Y') . '-';
            $latest = PelakuOlahraga::where('nomor_anggota', 'like', $prefix . '%')
                        ->orderBy('nomor_anggota', 'desc')
                        ->first();
            if ($latest && preg_match('/-(\d+)$/', $latest->nomor_anggota, $matches)) {
                $nextUrut = intval($matches[1]) + 1;
            } else {
                $nextUrut = 1;
            }
            $data['nomor_anggota'] = $prefix . str_pad($nextUrut, 4, '0', STR_PAD_LEFT);
        }
        if (!empty($data['kel_cabor'])) {
            $data['kel_cabor'] = \App\KelompokCabor::where('kode', $data['kel_cabor'])->value('nama') ?? $data['kel_cabor'];
        }

        if (auth()->user()->role === 'koni') {
            $data['kontingen'] = auth()->user()->name;
        }

        $pelaku = PelakuOlahraga::create($data);

        if ($dokumens) {
            foreach ($dokumens as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/dokumen_atlet'), $filename);
                $pelaku->dokumens()->create([
                    'file_path' => 'uploads/dokumen_atlet/' . $filename,
                    'nama_file' => $file->getClientOriginalName()
                ]);
            }
        }

        return redirect()->route('pelaku.index', $request->kategori)->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pelaku = PelakuOlahraga::findOrFail($id);
        if (auth()->user()->role === 'koni' && $pelaku->kontingen !== auth()->user()->name) {
            abort(403, 'Unauthorized action.');
        }
        $kategori = $pelaku->kategori;
        return view('pelaku_olahraga.edit', compact('pelaku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $pelaku = PelakuOlahraga::findOrFail($id);
        if (auth()->user()->role === 'koni' && $pelaku->kontingen !== auth()->user()->name) {
            abort(403, 'Unauthorized action.');
        }
        $data = $request->validate([
            'nama' => 'required|string',
            'jk' => 'required|in:L,P',
            'ttl' => 'nullable|string',
            'nik' => 'nullable|string',
            'no_wa' => 'nullable|string',
            'cabor' => 'nullable|string',
            'kel_cabor' => 'nullable|string',
            'kontingen' => 'nullable|string',
            'alamat' => 'nullable|string',
            'riwayat_kesehatan' => 'nullable|string',
            'bagian' => 'nullable|string',
            'koni' => 'nullable|string',
            'dokumen.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/dokumen_atlet'), $filename);
                $pelaku->dokumens()->create([
                    'file_path' => 'uploads/dokumen_atlet/' . $filename,
                    'nama_file' => $file->getClientOriginalName()
                ]);
            }
        }

        if ($request->hasFile('foto')) {
            // Hapus file foto lama jika ada
            if ($pelaku->foto && File::exists(public_path($pelaku->foto))) {
                File::delete(public_path($pelaku->foto));
            }
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/foto_atlet'), $filename);
            $data['foto'] = 'uploads/foto_atlet/' . $filename;
        }
        
        if ($pelaku->kategori != 'koni') {
            $prefixKategori = strtoupper($pelaku->kategori);
            $kodeKelompok = $request->kel_cabor;
            $kodeCabor = '';
            
            $cabor = \App\Cabor::where('kelompok_kode', $kodeKelompok)->where('nama', $request->cabor)->first();
            if ($cabor) {
                $kodeCabor = $cabor->kode;
            }
            
            $kodeKota = '';
            $kota = \App\Kota::where('nama', $request->kontingen)->first();
            if ($kota) {
                $kodeKota = $kota->kode;
            }
            
            if ($kodeKelompok && $kodeCabor && $kodeKota) {
                $prefix = $prefixKategori . ' ' . $kodeKelompok . $kodeCabor . '-' . $kodeKota . '-';
                if (!$pelaku->nomor_anggota || strpos($pelaku->nomor_anggota, $prefix) !== 0) {
                    $latest = PelakuOlahraga::where('nomor_anggota', 'like', $prefix . '%')
                                ->orderBy('nomor_anggota', 'desc')
                                ->first();
                    if ($latest && preg_match('/-(\d+)$/', $latest->nomor_anggota, $matches)) {
                        $nextUrut = intval($matches[1]) + 1;
                    } else {
                        $nextUrut = 1;
                    }
                    $data['nomor_anggota'] = $prefix . str_pad($nextUrut, 4, '0', STR_PAD_LEFT);
                }
            }
        }

        if (!empty($data['kel_cabor'])) {
            $data['kel_cabor'] = \App\KelompokCabor::where('kode', $data['kel_cabor'])->value('nama') ?? $data['kel_cabor'];
        }

        if (auth()->user()->role === 'koni') {
            $data['kontingen'] = auth()->user()->name;
        }

        $pelaku->update($data);
        return redirect()->route('pelaku.index', $pelaku->kategori)->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $pelaku = PelakuOlahraga::findOrFail($id);
        if (auth()->user()->role === 'koni' && $pelaku->kontingen !== auth()->user()->name) {
            abort(403, 'Unauthorized action.');
        }
        $kategori = $pelaku->kategori;

        // Delete all associated files
        foreach ($pelaku->dokumens as $dokumen) {
            if (File::exists(public_path($dokumen->file_path))) {
                File::delete(public_path($dokumen->file_path));
            }
        }
        if ($pelaku->foto && File::exists(public_path($pelaku->foto))) {
            File::delete(public_path($pelaku->foto));
        }

        $pelaku->delete();
        return redirect()->route('pelaku.index', $kategori)->with('success', 'Data berhasil dihapus');
    }

    public function destroyDokumen($id)
    {
        $dokumen = \App\DokumenPelakuOlahraga::findOrFail($id);
        if (File::exists(public_path($dokumen->file_path))) {
            File::delete(public_path($dokumen->file_path));
        }
        $dokumen->delete();
        return redirect()->back()->with('success', 'Dokumen berhasil dihapus');
    }

    public function cetakKartu($id)
    {
        $pelaku = PelakuOlahraga::findOrFail($id);
        return view('pelaku_olahraga.kartu', compact('pelaku'));
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\PelakuOlahragaTemplateExport, 'Template_Import_Pelaku_Olahraga.xlsx');
    }

    public function importExcel(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls'
        ]);

        $import = new \App\Imports\PelakuOlahragaImport;
        \Maatwebsite\Excel\Facades\Excel::import($import, $request->file('file_excel'));

        $message = "Berhasil mengimpor {$import->successCount} data.";
        if ($import->failCount > 0) {
            $message .= " Gagal mengimpor {$import->failCount} data. Detail: " . implode(' | ', $import->failMessages);
        }

        if ($import->failCount > 0) {
            return redirect()->back()->with('error', $message);
        }
        
        return redirect()->back()->with('success', $message);
    }
}
