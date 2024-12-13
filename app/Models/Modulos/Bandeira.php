<?php

namespace App\Models\Modulos;

use Illuminate\Database\Eloquent\Model;

class Bandeira extends Model
{
    protected $fillable = ['nome'];

    public function taxas()
    {
        return $this->hasMany(Taxa::class);
    }
}
