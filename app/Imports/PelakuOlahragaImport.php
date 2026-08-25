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

        // Skip example row
        if (trim($row['nama_lengkap_wajib'] ?? '') === 'Contoh Nama Atlit') {
            return null;
        }

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

        // Generate Nomor Anggota
        if ($data['kategori'] && $data['kategori'] != 'koni') {
            $prefixKategori = strtoupper($data['kategori']);
            $kodeKelompok = '';
            
            $kelCabor = \App\KelompokCabor::where('nama', $data['kel_cabor'])->first();
            if ($kelCabor) {
                $kodeKelompok = $kelCabor->kode;
            }
            
            $kodeCabor = '';
            if ($kodeKelompok) {
                $cabor = \App\Cabor::where('kelompok_kode', $kodeKelompok)->where('nama', $data['cabor'])->first();
                if ($cabor) {
                    $kodeCabor = $cabor->kode;
                }
            }
            
            $kodeKota = '';
            $kota = \App\Kota::where('nama', $data['kontingen'])->first();
            if ($kota) {
                $kodeKota = $kota->kode;
            }
            
            if ($kodeKelompok && $kodeCabor && $kodeKota) {
                $prefix = $prefixKategori . ' ' . $kodeKelompok . $kodeCabor . '-' . $kodeKota . '-';
                $latest = \App\PelakuOlahraga::where('nomor_anggota', 'like', $prefix . '%')
                            ->orderBy('nomor_anggota', 'desc')
                            ->first();
                if ($latest && preg_match('/-(\d+)$/', $latest->nomor_anggota, $matches)) {
                    $nextUrut = intval($matches[1]) + 1;
                } else {
                    $nextUrut = 1;
                }
                $data['nomor_anggota'] = $prefix . str_pad($nextUrut, 4, '0', STR_PAD_LEFT);
            }
        } elseif ($data['kategori'] == 'koni') {
            // Kategori KONI
            $prefix = 'KONI ' . date('Y') . '-';
            $latest = \App\PelakuOlahraga::where('nomor_anggota', 'like', $prefix . '%')
                        ->orderBy('nomor_anggota', 'desc')
                        ->first();
            if ($latest && preg_match('/-(\d+)$/', $latest->nomor_anggota, $matches)) {
                $nextUrut = intval($matches[1]) + 1;
            } else {
                $nextUrut = 1;
            }
            $data['nomor_anggota'] = $prefix . str_pad($nextUrut, 4, '0', STR_PAD_LEFT);
        }

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
