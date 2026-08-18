<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NakesJaga extends Model
{
    protected $guarded = [];

    public function nakes()
    {
        return $this->belongsTo(MasterNakes::class, 'nakes_id');
    }

    public function jadwalPertandingan()
    {
        return $this->belongsTo(JadwalPertandingan::class);
    }

    public function dataCederas()
    {
        return $this->hasMany(DataCedera::class);
    }

    public function absens()
    {
        return $this->hasMany(NakesJagaAbsen::class);
    }
}
