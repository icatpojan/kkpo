<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NakesJaga extends Model
{
    protected $fillable = [
        'tanggal', 'cabor', 'venue', 'nakes_id', 'personil', 'jumlah_cedera', 'keterangan', 'upload_absen', 'upload_foto'
    ];

    public function nakes()
    {
        return $this->belongsTo(MasterNakes::class, 'nakes_id');
    }
}
