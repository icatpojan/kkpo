<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\KelompokCabor;
use App\Cabor;
use App\Kota;

class PelakuOlahragaReferensiSheet implements FromCollection, WithHeadings, WithTitle
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
}
