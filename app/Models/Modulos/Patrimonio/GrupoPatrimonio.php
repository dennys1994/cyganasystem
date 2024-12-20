<?php

namespace App\Models\Modulos\Patrimonio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrupoPatrimonio extends Model
{
    use HasFactory;
    protected $table = 'grupo_patrimonios';
    protected $fillable = ['id_setor', 'nome', 'estado'];

    public function setor()
    {
        return $this->belongsTo(SetorPat::class, 'id_setor');
    }
    
    public function patrimoniospatrimonio()
    {
        return $this->hasMany(GrupoPatrimonioPatrimonio::class);
    }
}
