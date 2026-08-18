<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PelakuOlahraga;
use App\NakesJaga;
use App\Kegiatan;
use App\Berita;
use App\JadwalPertandingan;
use App\HeroSection;
use App\KelompokCabor;
use App\Cabor;
use PDF;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $pelakuOlahragaCount = PelakuOlahraga::count();
        $nakesCount = NakesJaga::count();
        $kegiatanCount = Kegiatan::count();
        $berita = Berita::latest()->take(3)->get();
        
        $jadwalQuery = JadwalPertandingan::with('kegiatan');
        
        if ($request->has('filter_kelompok_cabor') && $request->filter_kelompok_cabor != '') {
            $jadwalQuery->where('kel_cabor', $request->filter_kelompok_cabor);
        }

        if ($request->has('filter_cabor') && $request->filter_cabor != '') {
            $jadwalQuery->where('jenis_cabor', $request->filter_cabor);
        }
        
        if ($request->has('filter_kegiatan') && $request->filter_kegiatan != '') {
            $jadwalQuery->whereHas('kegiatan', function($q) use ($request) {
                $q->where('nama_kegiatan', 'like', '%' . $request->filter_kegiatan . '%');
            });
        }
        
        if ($request->has('filter_tanggal') && $request->filter_tanggal != '') {
            $jadwalQuery->whereDate('tanggal', $request->filter_tanggal);
        }

        $jadwal_pertandingans = $jadwalQuery->orderBy('tanggal', 'asc')->paginate(5)->onEachSide(1);
        
        // Fetch all events for FullCalendar
        $allKegiatans = Kegiatan::with(['jadwalPertandingans.nakesJagas.nakes'])->withCount('jadwalPertandingans')->get();
        $calendarEvents = $allKegiatans->map(function($k) {
            return [
                'title' => $k->nama_kegiatan,
                'start' => $k->tanggal_mulai,
                'end' => $k->tanggal_selesai ? \Carbon\Carbon::parse($k->tanggal_selesai)->addDay()->format('Y-m-d') : null, // FullCalendar end date is exclusive
                'lokasi' => $k->lokasi,
                'deskripsi' => $k->deskripsi,
                'color' => $k->is_khusus ? '#f97316' : '#82a8c7',
                'is_khusus' => $k->is_khusus,
                'jadwal_count' => $k->jadwal_pertandingans_count,
                'jadwals' => $k->jadwalPertandingans->map(function($j) {
                    return [
                        'tanggal' => $j->tanggal,
                        'waktu' => $j->waktu,
                        'jenis_cabor' => $j->jenis_cabor,
                        'venue' => $j->venue,
                        'alamat' => $j->alamat,
                        'link_google_map' => $j->link_google_map,
                        'nakes_jagas' => $j->nakesJagas->map(function($nj) {
                            return [
                                'nama' => $nj->nakes ? $nj->nakes->nama : 'N/A',
                                'instansi' => $nj->nakes ? $nj->nakes->instansi : 'N/A',
                                'spesialisasi' => $nj->nakes ? $nj->nakes->spesialisasi : 'N/A'
                            ];
                        })->toArray()
                    ];
                })
            ];
        });

        $atlits = PelakuOlahraga::where('kategori', 'atlit')->orderBy('nama')->get();
        $hero = HeroSection::first();
        
        $nakes_jaga_list = NakesJaga::with(['nakes', 'jadwalPertandingan'])
            ->whereDate('tanggal', now()->format('Y-m-d'))
            ->orderBy('tanggal', 'asc')
            ->get();
        
        $kelompokCabors = KelompokCabor::orderBy('nama')->get();
        $cabors = Cabor::orderBy('nama')->get();
        
        return view('welcome', compact('pelakuOlahragaCount', 'nakesCount', 'kegiatanCount', 'berita', 'jadwal_pertandingans', 'hero', 'calendarEvents', 'atlits', 'nakes_jaga_list', 'kelompokCabors', 'cabors'));
    }

    public function cetakJadwalTanding(Request $request)
    {
        $jadwalQuery = JadwalPertandingan::with(['kegiatan', 'nakesJagas.nakes']);
        
        if ($request->has('filter_kelompok_cabor') && $request->filter_kelompok_cabor != '') {
            $jadwalQuery->where('kel_cabor', $request->filter_kelompok_cabor);
        }
        
        if ($request->has('filter_cabor') && $request->filter_cabor != '') {
            $jadwalQuery->where('jenis_cabor', $request->filter_cabor);
        }
        
        if ($request->has('filter_tanggal') && $request->filter_tanggal != '') {
            $jadwalQuery->whereDate('tanggal', $request->filter_tanggal);
        }
        
        if ($request->has('filter_kegiatan') && $request->filter_kegiatan != '') {
            $jadwalQuery->whereHas('kegiatan', function($q) use ($request) {
                $q->where('nama_kegiatan', 'like', '%' . $request->filter_kegiatan . '%');
            });
        }

        $jadwal_pertandingans = $jadwalQuery->orderBy('tanggal', 'asc')->get();
        
        $pdf = PDF::loadView('pdf.jadwal-tanding', compact('jadwal_pertandingans'));
        return $pdf->stream('jadwal-tanding.pdf');
    }

    public function caborInfo(Request $request)
    {
        $cabor = $request->cabor;
        
        $atlitCount = PelakuOlahraga::where('cabor', $cabor)->where('kategori', 'atlit')->count();
        $pelatihCount = PelakuOlahraga::where('cabor', $cabor)->where('kategori', 'pelatih')->count();
        $koniCount = PelakuOlahraga::where('cabor', $cabor)->whereIn('kategori', ['koni', 'official'])->count(); // Combining koni and official
        
        $jadwals = JadwalPertandingan::with(['kegiatan', 'nakesJagas.nakes'])
            ->where('jenis_cabor', $cabor)
            ->orderBy('tanggal', 'asc')
            ->get()
            ->map(function($j) {
                return [
                    'tanggal' => \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y'),
                    'waktu' => $j->waktu,
                    'kegiatan' => $j->kegiatan ? $j->kegiatan->nama_kegiatan : '-',
                    'venue' => $j->venue,
                    'alamat' => $j->alamat,
                    'link_google_map' => $j->link_google_map,
                    'nakes_jagas' => $j->nakesJagas->map(function($nj) {
                        return [
                            'nama' => $nj->nakes ? $nj->nakes->nama : 'N/A',
                            'instansi' => $nj->nakes ? $nj->nakes->instansi : 'N/A',
                            'spesialisasi' => $nj->nakes ? $nj->nakes->spesialisasi : 'N/A'
                        ];
                    })->toArray()
                ];
            });
            
        return response()->json([
            'cabor' => $cabor,
            'atlit' => $atlitCount,
            'pelatih' => $pelatihCount,
            'koni' => $koniCount,
            'jadwals' => $jadwals
        ]);
    }
}
