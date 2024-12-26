<?php

namespace App\Models\Modulos;

use Illuminate\Database\Eloquent\Model;

class DadosDigisac extends Model
{
    protected $table = 'dados_digisac';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['token'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
