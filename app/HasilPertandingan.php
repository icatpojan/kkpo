<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilPertandingan extends Model
{
    protected $guarded = [];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function emasPelaku()
    {
        return $this->belongsTo(PelakuOlahraga::class, 'emas_pelaku_id');
    }

    public function perakPelaku()
    {
        return $this->belongsTo(PelakuOlahraga::class, 'perak_pelaku_id');
    }

    public function perungguPelaku()
    {
        return $this->belongsTo(PelakuOlahraga::class, 'perunggu_pelaku_id');
    }

    /**
     * Menghitung klasemen perolehan medali per daerah / kontingen
     * 
     * @param int|null $kegiatanId
     * @return array
     */
    public static function getKlasemenMedali($kegiatanId = null)
    {
        $standardDaerahs = [
            'KOTA TANGERANG',
            'KAB. TANGERANG',
            'KOTA TANGERANG SELATAN',
            'KOTA SERANG',
            'KOTA CILEGON',
            'KAB. LEBAK',
            'KAB. SERANG',
            'KAB. PANDEGLANG',
        ];

        $aliases = [
            'TANGERANG KOTA' => 'KOTA TANGERANG',
            'TANGERANG KAB' => 'KAB. TANGERANG',
            'TANGERANG SELATAN' => 'KOTA TANGERANG SELATAN',
            'SERANG KOTA' => 'KOTA SERANG',
            'SERANG KAB' => 'KAB. SERANG',
            'LEBAK' => 'KAB. LEBAK',
            'PANDEGLANG' => 'KAB. PANDEGLANG',
            'CILEGON' => 'KOTA CILEGON',
        ];

        $normalize = function ($name) use ($aliases) {
            if (!$name) return null;
            $upper = strtoupper(trim($name));
            return $aliases[$upper] ?? $upper;
        };

        $query = self::query();
        if ($kegiatanId) {
            $query->where('kegiatan_id', $kegiatanId);
        }

        $results = $query->get();

        $tally = [];
        foreach ($standardDaerahs as $daerah) {
            $tally[$daerah] = [
                'nama' => $daerah,
                'emas' => 0,
                'perak' => 0,
                'perunggu' => 0,
                'total' => 0,
            ];
        }

        foreach ($results as $item) {
            // Emas
            if ($item->emas_kontingen) {
                $kontingen = $normalize($item->emas_kontingen);
                if (!isset($tally[$kontingen])) {
                    $tally[$kontingen] = ['nama' => $kontingen, 'emas' => 0, 'perak' => 0, 'perunggu' => 0, 'total' => 0];
                }
                $tally[$kontingen]['emas']++;
            }

            // Perak
            if ($item->perak_kontingen) {
                $kontingen = $normalize($item->perak_kontingen);
                if (!isset($tally[$kontingen])) {
                    $tally[$kontingen] = ['nama' => $kontingen, 'emas' => 0, 'perak' => 0, 'perunggu' => 0, 'total' => 0];
                }
                $tally[$kontingen]['perak']++;
            }

            // Perunggu
            if ($item->perunggu_kontingen) {
                $kontingen = $normalize($item->perunggu_kontingen);
                if (!isset($tally[$kontingen])) {
                    $tally[$kontingen] = ['nama' => $kontingen, 'emas' => 0, 'perak' => 0, 'perunggu' => 0, 'total' => 0];
                }
                $tally[$kontingen]['perunggu']++;
            }
        }

        // Hitung total dan urutkan
        $klasemen = [];
        $totalEmas = 0;
        $totalPerak = 0;
        $totalPerunggu = 0;

        foreach ($tally as $item) {
            $item['total'] = $item['emas'] + $item['perak'] + $item['perunggu'];
            $totalEmas += $item['emas'];
            $totalPerak += $item['perak'];
            $totalPerunggu += $item['perunggu'];
            $klasemen[] = $item;
        }

        // Sorting: Emas DESC, Perak DESC, Perunggu DESC, Nama ASC
        usort($klasemen, function ($a, $b) {
            if ($b['emas'] !== $a['emas']) {
                return $b['emas'] <=> $a['emas'];
            }
            if ($b['perak'] !== $a['perak']) {
                return $b['perak'] <=> $a['perak'];
            }
            if ($b['perunggu'] !== $a['perunggu']) {
                return $b['perunggu'] <=> $a['perunggu'];
            }
            return strcmp($a['nama'], $b['nama']);
        });

        $grandTotal = $totalEmas + $totalPerak + $totalPerunggu;

        return [
            'klasemen' => $klasemen,
            'totalEmas' => $totalEmas,
            'totalPerak' => $totalPerak,
            'totalPerunggu' => $totalPerunggu,
            'grandTotal' => $grandTotal,
        ];
    }
}
