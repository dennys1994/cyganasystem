<?php

namespace App\Models\Modulos;

use Illuminate\Database\Eloquent\Model;

class Taxa extends Model
{
    protected $fillable = ['bandeira_id', 'parcelas', 'percentual'];

    public function bandeira()
    {
        return $this->belongsTo(Bandeira::class);
    }
}

