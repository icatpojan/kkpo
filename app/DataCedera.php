<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataCedera extends Model
{
    protected $guarded = [];

    public function pelakuOlahraga()
    {
        return $this->belongsTo(PelakuOlahraga::class);
    }

    public function nakesJaga()
    {
        return $this->belongsTo(NakesJaga::class);
    }

    public function jadwalPertandingan()
    {
        return $this->belongsTo(JadwalPertandingan::class);
    }

    public function images()
    {
        return $this->hasMany(DataCederaImage::class);
    }

    public function riwayatPerawatans()
    {
        return $this->hasMany(RiwayatPerawatanCedera::class)->orderBy('tanggal_waktu', 'desc');
    }
}
