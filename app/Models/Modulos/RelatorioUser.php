<?php

namespace App\Models\Modulos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatorioUser extends Model
{
    use HasFactory;

    protected $table = 'relatorio_users';

    protected $fillable = ['name', 'email', 'auth_sige', 'app_name', 'auth_milvus'];
}
