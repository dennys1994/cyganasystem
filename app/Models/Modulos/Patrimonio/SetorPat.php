<?php

namespace App\Models\Modulos\Patrimonio;

use Illuminate\Database\Eloquent\Model;

class SetorPat extends Model
{
     // Defina o nome da tabela caso seja diferente do plural do nome do model
     protected $table = 'setor_pats';

     // Defina os campos que são passíveis de atribuição em massa
     protected $fillable = ['nome'];
 
     // Caso o nome da chave primária seja diferente de 'id', defina aqui
     protected $primaryKey = 'id';
 
     // Caso a tabela não utilize os timestamps (created_at e updated_at), defina:
     public $timestamps = true;
}
