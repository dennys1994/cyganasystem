<?php

namespace App\Models\Modulos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresa'; // Nome da tabela no banco de dados

    protected $fillable = [
        'id_milvus',
        'id_digisac',
        'num_max_horas',
        'id_responsavel_digisac',
        'nome',
        'cod_aviso',
    ]; // Colunas permitidas para atribuição em massa
}
