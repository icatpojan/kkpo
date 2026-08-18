<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JadwalPertandingan extends Model
{
    protected $guarded = [];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function nakesJagas()
    {
        return $this->hasMany(NakesJaga::class);
    }
}
