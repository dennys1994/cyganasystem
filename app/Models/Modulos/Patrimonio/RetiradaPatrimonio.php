<?php

namespace App\Models\Modulos\Patrimonio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class RetiradaPatrimonio extends Model
{
    use HasFactory;

    // Definindo o nome da tabela caso seja diferente do padrão (plural do nome do model)
    protected $table = 'retirada_patrimonios';

    // Definindo os campos que são mass assignable
    protected $fillable = [
        'id_user_resp',
        'id_user_tec',
        'patrimonios',
        'grupos',
        'anotacoes',
        'estado',
    ];

    // Definindo os campos que serão automaticamente convertidos para arrays
    protected $casts = [
        'patrimonios' => 'array',  // Convertendo o campo 'patrimonios' para array automaticamente
        'grupos' => 'array',       // Convertendo o campo 'grupos' para array automaticamente
    ];

    // Relacionamentos
    public function responsavel()
    {
        return $this->belongsTo(User::class, 'id_user_resp');
    }

    public function tecnicoResponsavel()
    {
        return $this->belongsTo(User::class, 'id_user_tec');
    }
}
