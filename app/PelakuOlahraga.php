<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PelakuOlahraga extends Model
{
    protected $guarded = [];

    public function dataCederas()
    {
        return $this->hasMany(DataCedera::class);
    }
}
