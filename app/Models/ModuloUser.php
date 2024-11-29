<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ModuloUser extends Pivot
{
    use HasFactory;

    // Defina a tabela associada ao model
    protected $table = 'modulo_user';

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = [
        'user_id',
        'modulo_id',
        'permissao'
    ];

    // Relacionamento: ModuloUser pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento: ModuloUser pertence a um módulo
    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }
}
