<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use App\KelompokCabor;
use App\Kota;
use App\Cabor;

class PelakuOlahragaDataSheet implements WithHeadings, WithEvents, WithTitle
{
    public function title(): string
    {
        return 'Data Pelaku Olahraga';
    }

    public function headings(): array
    {
        return [
            ['Kategori (*Wajib)', 'Nama Lengkap (*Wajib)', 'Jenis Kelamin (*Wajib)', 'Tempat, Tanggal Lahir', 'NIK', 'No. WhatsApp', 'Kelompok Cabor', 'Cabang Olahraga', 'Asal Kontingen (Kota)', 'Alamat Domisili', 'Riwayat Kesehatan', 'Keterangan Bagian (Khusus Official)', 'Keterangan Jabatan (Khusus KONI)'],
            ['atlit', 'Contoh Nama Atlit', 'L', 'Jakarta, 12 Agustus 1990', '3271234567890001', '08123456789', 'Bela Diri (BD)', 'ANGGAR', 'TANGERANG SELATAN', 'Jl. Merdeka No 1', 'Tidak Ada', '', '']
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Get counts for validation references
                $kelompokCaborCount = KelompokCabor::count();
                $kotaCount = Kota::count();
                $caborCount = Cabor::count();

                $rowCount = 500;

                // Validation Kategori (Col A) -> Referensi A2:A5
                $validationKategori = $sheet->getCell('A3')->getDataValidation();
                $validationKategori->setType(DataValidation::TYPE_LIST);
                $validationKategori->setErrorStyle(DataValidation::STYLE_STOP);
                $validationKategori->setAllowBlank(false);
                $validationKategori->setShowDropDown(true);
                $validationKategori->setErrorTitle('Input Error');
                $validationKategori->setError('Kategori harus dipilih dari daftar dropdown.');
                $validationKategori->setFormula1('=\'Referensi\'!$A$2:$A$5');
                $sheet->setDataValidation("A3:A{$rowCount}", $validationKategori);

                // Validation JK (Col C) -> Referensi B2:B3
                $validationJk = $sheet->getCell('C3')->getDataValidation();
                $validationJk->setType(DataValidation::TYPE_LIST);
                $validationJk->setErrorStyle(DataValidation::STYLE_STOP);
                $validationJk->setAllowBlank(false);
                $validationJk->setShowDropDown(true);
                $validationJk->setErrorTitle('Input Error');
                $validationJk->setError('Jenis Kelamin harus L atau P.');
                $validationJk->setFormula1('=\'Referensi\'!$B$2:$B$3');
                $sheet->setDataValidation("C3:C{$rowCount}", $validationJk);

                // Validation Kelompok Cabor (Col G) -> Referensi C2:C...
                if ($kelompokCaborCount > 0) {
                    $validationKelCabor = $sheet->getCell('G3')->getDataValidation();
                    $validationKelCabor->setType(DataValidation::TYPE_LIST);
                    $validationKelCabor->setErrorStyle(DataValidation::STYLE_STOP);
                    $validationKelCabor->setAllowBlank(true);
                    $validationKelCabor->setShowDropDown(true);
                    $validationKelCabor->setFormula1('=\'Referensi\'!$C$2:$C$' . ($kelompokCaborCount + 1));
                    $sheet->setDataValidation("G3:G{$rowCount}", $validationKelCabor);
                }

                // Validation Cabang Olahraga (Col H) -> Referensi D2:D...
                if ($caborCount > 0) {
                    $validationCabor = $sheet->getCell('H3')->getDataValidation();
                    $validationCabor->setType(DataValidation::TYPE_LIST);
                    $validationCabor->setErrorStyle(DataValidation::STYLE_STOP);
                    $validationCabor->setAllowBlank(true);
                    $validationCabor->setShowDropDown(true);
                    $validationCabor->setFormula1('=\'Referensi\'!$D$2:$D$' . ($caborCount + 1));
                    $sheet->setDataValidation("H3:H{$rowCount}", $validationCabor);
                }

                // Validation Kontingen (Col I) -> Referensi E2:E...
                if ($kotaCount > 0) {
                    $validationKota = $sheet->getCell('I3')->getDataValidation();
                    $validationKota->setType(DataValidation::TYPE_LIST);
                    $validationKota->setErrorStyle(DataValidation::STYLE_STOP);
                    $validationKota->setAllowBlank(true);
                    $validationKota->setShowDropDown(true);
                    $validationKota->setFormula1('=\'Referensi\'!$E$2:$E$' . ($kotaCount + 1));
                    $sheet->setDataValidation("I3:I{$rowCount}", $validationKota);
                }

                // Styling the header (Row 1)
                $sheet->getStyle('A1:M1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF0D6EFD']],
                ]);

                // Styling the example row (Row 2)
                $sheet->getStyle('A2:M2')->applyFromArray([
                    'font' => ['italic' => true, 'color' => ['argb' => 'FF6C757D']],
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF8F9FA']],
                ]);
                
                // Add instructional comment on row 2
                $sheet->getComment('A2')->getText()->createTextRun('Ini adalah baris contoh. Silakan timpa baris ini atau mulai isi dari baris 3 ke bawah.');

                // Auto-size columns
                foreach (range('A', 'M') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
