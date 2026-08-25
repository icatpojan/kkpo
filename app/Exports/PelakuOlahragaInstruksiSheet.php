<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class PelakuOlahragaInstruksiSheet implements FromCollection, WithEvents, WithTitle
{
    public function title(): string
    {
        return 'Cara Pengisian';
    }

    public function collection()
    {
        return collect([
            ['PANDUAN PENGISIAN DATA PELAKU OLAHRAGA'],
            [''],
            ['1', 'Kolom dengan tanda (*Wajib) tidak boleh dibiarkan kosong.'],
            ['2', 'Kategori: Pilih salah satu dari dropdown (atlit, pelatih, official, koni).'],
            ['3', 'Jenis Kelamin: Pilih dari dropdown (L / P).'],
            ['4', 'Kelompok Cabor & Cabang Olahraga: Wajib diisi jika Kategori selain KONI. Pilih sesuai opsi.'],
            ['5', 'Asal Kontingen (Kota): Pilih sesuai dengan dropdown yang tersedia.'],
            ['6', 'Baris ke-2 pada sheet "Data Pelaku Olahraga" adalah contoh. Baris tersebut tidak akan tersimpan saat Anda melakukan upload, jadi Anda boleh menghapusnya atau langsung menimpanya.'],
            ['7', 'Nomer Anggota akan otomatis dibuat (digenerate) oleh sistem saat file Excel di-upload ke aplikasi.'],
            [''],
            ['Catatan Tambahan:'],
            ['', '- Pastikan format tanggal mengikuti format text yang rapih (misal: Jakarta, 17 Agustus 1945).'],
            ['', '- NIK harap diisi dengan benar sesuai KTP.'],
            ['', '- Pastikan tidak mengubah nama Sheet "Data Pelaku Olahraga" agar sistem dapat membaca data dengan benar.']
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Styling
                $sheet->getStyle('A1:B1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                ]);
                $sheet->getStyle('A11:B11')->applyFromArray([
                    'font' => ['bold' => true, 'italic' => true],
                ]);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setAutoSize(true);
            },
        ];
    }
}
