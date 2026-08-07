<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterNakes extends Model
{
    protected $table = 'master_nakes';
    protected $fillable = ['nama', 'spesialisasi', 'no_str', 'instansi', 'no_wa'];

    public function nakes_jagas()
    {
        return $this->hasMany(NakesJaga::class, 'nakes_id');
    }
}
