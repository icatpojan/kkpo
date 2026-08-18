<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataCederaImage extends Model
{
    protected $guarded = [];

    public function dataCedera()
    {
        return $this->belongsTo(DataCedera::class);
    }
}
