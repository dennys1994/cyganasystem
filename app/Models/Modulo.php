<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;

    // Defina a tabela associada ao model
    protected $table = 'modulos';

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'descricao',
        'ativo'
    ];

    // Relacionamento: Modulo pode ter vários usuários com permissões
    public function users()
    {
        return $this->belongsToMany(User::class, 'modulo_user')
                    ->withPivot('permissao')
                    ->withTimestamps();
    }
}
