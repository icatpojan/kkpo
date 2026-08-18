<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NakesJagaAbsen extends Model
{
    protected $table = 'nakes_absens';
    protected $guarded = [];

    public function nakesJaga()
    {
        return $this->belongsTo(NakesJaga::class);
    }
}
