<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NakesJagaAbsen;
use PDF;

class NakesAbsenController extends Controller
{
    public function index(Request $request)
    {
        $query = NakesJagaAbsen::with('nakesJaga.jadwalPertandingan.kegiatan')
            ->orderBy('created_at', 'desc');

        // Filter by Date Range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('created_at', '>=', $request->start_date)
                  ->whereDate('created_at', '<=', $request->end_date);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('created_at', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by Search Keyword (Nama, Instansi, atau Kegiatan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('instansi', 'like', "%{$search}%")
                  ->orWhereHas('nakesJaga.jadwalPertandingan.kegiatan', function($q) use ($search) {
                      $q->where('nama_kegiatan', 'like', "%{$search}%");
                  });
            });
        }

        $absens = $query->paginate(20);

        return view('nakes_absen.index', compact('absens'));
    }

    public function exportPdf(Request $request)
    {
        $query = NakesJagaAbsen::with('nakesJaga.jadwalPertandingan.kegiatan')
            ->orderBy('created_at', 'desc');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('created_at', '>=', $request->start_date)
                  ->whereDate('created_at', '<=', $request->end_date);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('created_at', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('instansi', 'like', "%{$search}%")
                  ->orWhereHas('nakesJaga.jadwalPertandingan.kegiatan', function($q) use ($search) {
                      $q->where('nama_kegiatan', 'like', "%{$search}%");
                  });
            });
        }

        $absens = $query->get();

        $pdf = PDF::loadView('nakes_absen.pdf', compact('absens', 'request'))->setPaper('a4', 'portrait');
        return $pdf->stream('laporan_absensi_nakes.pdf');
    }
}
