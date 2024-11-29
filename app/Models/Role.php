<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Caso o nome da tabela não seja a forma plural de 'Role', defina explicitamente
    // protected $table = 'roles';

    // Definindo quais campos podem ser preenchidos em massa
    protected $fillable = ['name', 'permissions'];

    // Relacionamento: Um role pode ter muitos usuários (um para muitos)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
