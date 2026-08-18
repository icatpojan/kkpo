<?php

namespace App\Imports;

use App\PelakuOlahraga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Exception;

class PelakuOlahragaImport implements ToModel, WithHeadingRow
{
    public $successCount = 0;
    public $failCount = 0;
    public $failMessages = [];

    public function model(array $row)
    {
        // Handle empty rows
        if (!isset($row['kategori_wajib']) && !isset($row['nama_lengkap_wajib'])) {
            return null;
        }

        // Map the columns based on the headings.
        // Maatwebsite\Excel automatically slugifies headings:
        // 'Kategori (*Wajib)' -> 'kategori_wajib'
        // 'Nama Lengkap (*Wajib)' -> 'nama_lengkap_wajib'
        // 'Jenis Kelamin (*Wajib)' -> 'jenis_kelamin_wajib'
        // 'Tempat, Tanggal Lahir' -> 'tempat_tanggal_lahir'
        // 'NIK' -> 'nik'
        // 'No. WhatsApp' -> 'no_whatsapp'
        // 'Kelompok Cabor' -> 'kelompok_cabor'
        // 'Cabang Olahraga' -> 'cabang_olahraga'
        // 'Asal Kontingen (Kota)' -> 'asal_kontingen_kota'
        // 'Alamat Domisili' -> 'alamat_domisili'
        // 'Riwayat Kesehatan' -> 'riwayat_kesehatan'
        // 'Keterangan Bagian (Khusus Official)' -> 'keterangan_bagian_khusus_official'
        // 'Keterangan Jabatan (Khusus KONI)' -> 'keterangan_jabatan_khusus_koni'

        $data = [
            'kategori' => $row['kategori_wajib'] ?? null,
            'nama' => $row['nama_lengkap_wajib'] ?? null,
            'jk' => $row['jenis_kelamin_wajib'] ?? null,
            'ttl' => $row['tempat_tanggal_lahir'] ?? null,
            'nik' => $row['nik'] ?? null,
            'no_wa' => $row['no_whatsapp'] ?? null,
            'kel_cabor' => $row['kelompok_cabor'] ?? null,
            'cabor' => $row['cabang_olahraga'] ?? null,
            'kontingen' => $row['asal_kontingen_kota'] ?? null,
            'alamat' => $row['alamat_domisili'] ?? null,
            'riwayat_kesehatan' => $row['riwayat_kesehatan'] ?? null,
            'bagian' => $row['keterangan_bagian_khusus_official'] ?? null,
            'koni' => $row['keterangan_jabatan_khusus_koni'] ?? null,
        ];

        $validator = Validator::make($data, [
            'kategori' => 'required|in:atlit,pelatih,official,koni',
            'nama' => 'required|string',
            'jk' => 'required|in:L,P',
        ]);

        if ($validator->fails()) {
            $this->failCount++;
            $this->failMessages[] = "Baris gagal validasi: " . implode(', ', $validator->errors()->all());
            return null;
        }

        try {
            $pelaku = PelakuOlahraga::create($data);
            $this->successCount++;
            return $pelaku;
        } catch (Exception $e) {
            $this->failCount++;
            $this->failMessages[] = "Baris dengan nama {$data['nama']} gagal: " . $e->getMessage();
            return null;
        }
    }
}
