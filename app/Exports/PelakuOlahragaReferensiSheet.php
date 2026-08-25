<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\KelompokCabor;
use App\Cabor;
use App\Kota;

class PelakuOlahragaReferensiSheet implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    public function title(): string
    {
        return 'Referensi';
    }

    public function headings(): array
    {
        return [
            'Pilihan Kategori',
            'Pilihan Jenis Kelamin',
            'Pilihan Kelompok Cabor',
            'Pilihan Cabang Olahraga',
            'Pilihan Kontingen (Kota)'
        ];
    }

    public function collection()
    {
        $kategori = ['atlit', 'pelatih', 'official', 'koni'];
        $jk = ['L', 'P'];
        $kelompokCabors = KelompokCabor::pluck('nama')->toArray();
        $cabors = Cabor::pluck('nama')->toArray();
        $kotas = Kota::pluck('nama')->toArray();

        // Find the maximum length among all arrays
        $maxCount = max(count($kategori), count($jk), count($kelompokCabors), count($cabors), count($kotas));

        $rows = [];
        for ($i = 0; $i < $maxCount; $i++) {
            $rows[] = [
                $kategori[$i] ?? null,
                $jk[$i] ?? null,
                $kelompokCabors[$i] ?? null,
                $cabors[$i] ?? null,
                $kotas[$i] ?? null,
            ];
        }

        return collect($rows);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Auto-size all columns in reference sheet
                foreach (range('A', 'E') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Styling the header
                $sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF6C757D']],
                ]);
            },
        ];
    }
}
