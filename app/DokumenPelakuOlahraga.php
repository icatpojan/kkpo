<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DokumenPelakuOlahraga extends Model
{
    protected $guarded = [];

    public function pelakuOlahraga()
    {
        return $this->belongsTo(PelakuOlahraga::class);
    }
}
