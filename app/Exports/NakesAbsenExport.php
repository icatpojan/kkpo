<?php

namespace App\Exports;

use App\NakesJagaAbsen;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Http\Request;

class NakesAbsenExport implements FromView, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = NakesJagaAbsen::with('nakesJaga.jadwalPertandingan.kegiatan')
            ->orderBy('created_at', 'desc');

        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->whereDate('created_at', '>=', $this->request->start_date)
                  ->whereDate('created_at', '<=', $this->request->end_date);
        } elseif ($this->request->filled('start_date')) {
            $query->whereDate('created_at', $this->request->start_date);
        } elseif ($this->request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $this->request->end_date);
        }

        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('instansi', 'like', "%{$search}%")
                  ->orWhereHas('nakesJaga.jadwalPertandingan.kegiatan', function($q) use ($search) {
                      $q->where('nama_kegiatan', 'like', "%{$search}%");
                  });
            });
        }

        $absens = $query->get();
        $request = $this->request;

        return view('nakes_absen.excel', compact('absens', 'request'));
    }
}
