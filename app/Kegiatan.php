<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $guarded = [];

    public function jadwalPertandingans()
    {
        return $this->hasMany(JadwalPertandingan::class);
    }
}
