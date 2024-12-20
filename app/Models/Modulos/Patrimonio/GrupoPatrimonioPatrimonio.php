<?php

namespace App\Models\Modulos\Patrimonio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Modulos\Patrimonio;

class GrupoPatrimonioPatrimonio extends Model
{
    use HasFactory;

    protected $table = 'grupo_patrimonio_items';

    // Definir os campos que podem ser preenchidos via mass assignment
    protected $fillable = [
       'id_grupo_patrimonio',
       'id_patrimonio',
       'nome',
       'serie',
    ];

    // Relacionamento com GrupoPatrimonio
    public function grupoPatrimonio()
    {
        return $this->belongsTo(GrupoPatrimonio::class);
    }

    // Relacionamento com Patrimonio
    public function patrimonio()
    {
        return $this->belongsTo(Patrimonio::class);
    }
}
