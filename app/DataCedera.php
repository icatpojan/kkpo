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
}
