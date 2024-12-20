<?php

namespace App\Models\Modulos;

use App\Models\Modulos\Patrimonio\SetorPat;
use App\Models\Modulos\Patrimonio\FuncaoPat;
use App\Models\Modulos\Patrimonio\TamanhoPat;
use App\Models\Modulos\Patrimonio\GrupoPatrimonio;
use App\Models\Modulos\Patrimonio\GrupoPatrimonioPatrimonio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patrimonio extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nome_abv',
        'nome_completo',
        'series',
        'setor_pat_id',
        'funcao_pat_id',
        'tamanho_pat_id',
        'tipo_patrimonio',
    ];

    protected $casts = [
        'series' => 'array', // Converte JSON para array automaticamente
    ];

    public function setorPat()
    {
        return $this->belongsTo(SetorPat::class);
    }

    public function funcaoPat()
    {
        return $this->belongsTo(FuncaoPat::class);
    }

    public function tamanhoPat()
    {
        return $this->belongsTo(TamanhoPat::class);
    }
    // Relacionamento com a tabela GrupoPatrimonio
    public function grupos()
    {
        return $this->belongsToMany(GrupoPatrimonio::class, 'grupo_patrimonio_patrimonio');
    }

    public function grupoPatrimonios()
    {
        return $this->hasMany(GrupoPatrimonioPatrimonio::class);
    }
}
