<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PelakuOlahraga;
use App\DataCedera;
use App\NakesJaga;
use App\Kegiatan;
use DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // 1. Get Filters
        $tahun = $request->input('tahun', date('Y'));
        $cabor = $request->input('cabor', '');

        // Base Query for Cedera (Join with pelaku_olahragas to filter by cabor)
        $cederaQuery = DataCedera::select('data_cederas.*', 'pelaku_olahragas.cabor')
            ->join('pelaku_olahragas', 'data_cederas.pelaku_olahraga_id', '=', 'pelaku_olahragas.id');

        if ($cabor != '') {
            $cederaQuery->where('pelaku_olahragas.cabor', $cabor);
        }

        // Base Query for Pelaku Olahraga (Atlit)
        $pelakuQuery = PelakuOlahraga::where('kategori', 'atlit');
        if ($cabor != '') {
            $pelakuQuery->where('cabor', $cabor);
        }

        // 2. KPIs
        $athleteCount = $pelakuQuery->count();
        $incidentCount = $cederaQuery->count();
        $cederaAktif = (clone $cederaQuery)->whereNotIn('data_cederas.status', ['sembuh'])->count();
        $rujukanCount = (clone $cederaQuery)->where('data_cederas.status', 'rujuk')->count();
        $belumDitangani = (clone $cederaQuery)->where('data_cederas.status', 'cedera')->count();
        
        $totalSembuh = (clone $cederaQuery)->where('data_cederas.status', 'sembuh')->count();
        $sembuhRate = $incidentCount > 0 ? round(($totalSembuh / $incidentCount) * 100) : 0;

        // 3. Trend Line Chart (Cedera per Bulan di Tahun ini)
        $trendData = [];
        $trendLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        for ($m = 1; $m <= 12; $m++) {
            $count = (clone $cederaQuery)->whereYear('waktu_kejadian', $tahun)->whereMonth('waktu_kejadian', $m)->count();
            $trendData[] = $count;
        }

        // 4. Doughnut Chart (Distribusi Bagian Tubuh Cedera)
        $bodyPartsRaw = (clone $cederaQuery)
            ->select('bagian_cedera', DB::raw('count(*) as total'))
            ->whereYear('waktu_kejadian', $tahun)
            ->whereNotNull('bagian_cedera')
            ->groupBy('bagian_cedera')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
        $bodyPartLabels = $bodyPartsRaw->pluck('bagian_cedera')->toArray();
        $bodyPartData = $bodyPartsRaw->pluck('total')->toArray();

        // 5. Bar Chart (Cedera per Cabor)
        $caborRaw = DataCedera::join('pelaku_olahragas', 'data_cederas.pelaku_olahraga_id', '=', 'pelaku_olahragas.id')
            ->select('pelaku_olahragas.cabor', DB::raw('count(*) as total'))
            ->whereYear('waktu_kejadian', $tahun)
            ->whereNotNull('pelaku_olahragas.cabor')
            ->groupBy('pelaku_olahragas.cabor')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
        $caborLabels = $caborRaw->pluck('cabor')->toArray();
        $caborData = $caborRaw->pluck('total')->toArray();

        // 6. Latest Incidents
        $latestIncidents = (clone $cederaQuery)
            ->orderBy('waktu_kejadian', 'desc')
            ->take(5)
            ->get();

        // Dropdown List Data
        $listCabor = PelakuOlahraga::whereNotNull('cabor')->distinct()->orderBy('cabor', 'asc')->pluck('cabor');
        // List years based on existing records
        $listTahun = DataCedera::whereNotNull('waktu_kejadian')
            ->select(DB::raw('YEAR(waktu_kejadian) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')->toArray();
        if(!in_array(date('Y'), $listTahun)) {
            array_unshift($listTahun, date('Y'));
        }

        // 7. Klasemen Perolehan Medali
        $medaliData = \App\HasilPertandingan::getKlasemenMedali();

        // 8. Data for Nakes Quick Action Modals
        $atlits = PelakuOlahraga::where('kategori', 'atlit')->orderBy('nama')->get();
        $nakes_jaga_list = \App\NakesJaga::with('jadwalPertandingan')->orderBy('tanggal', 'desc')->get();

        return view('home', compact(
            'tahun', 'cabor', 'listCabor', 'listTahun',
            'athleteCount', 'incidentCount', 'cederaAktif', 'rujukanCount', 'sembuhRate', 'totalSembuh', 'belumDitangani',
            'trendLabels', 'trendData',
            'bodyPartLabels', 'bodyPartData',
            'caborLabels', 'caborData',
            'latestIncidents',
            'medaliData',
            'atlits',
            'nakes_jaga_list'
        ));
    }
}
