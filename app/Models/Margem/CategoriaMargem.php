<?php

// app/Models/CategoriaMargem.php

namespace App\Models\Margem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaMargem extends Model
{
    use HasFactory;

    protected $table = 'categorias_margem';

    protected $fillable = ['nome', 'descricao'];

    public function faixasPreco()
    {
        return $this->hasMany(FaixaPreco::class);
    }
}
