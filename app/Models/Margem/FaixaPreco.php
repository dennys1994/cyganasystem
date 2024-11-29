<?php

// app/Models/FaixaPreco.php

namespace App\Models\Margem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaixaPreco extends Model
{
    use HasFactory;
    
    protected $table = 'faixas_precos';

    protected $fillable = ['categoria_id', 'min', 'max', 'avista', 'parcelado'];

    public function categoriaMargem()
    {
        return $this->belongsTo(CategoriaMargem::class, 'categoria_id');
    }
}
