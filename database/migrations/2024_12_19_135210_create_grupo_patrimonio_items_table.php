<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrupoPatrimonioItemsTable extends Migration
{
    public function up()
    {
        Schema::create('grupo_patrimonio_items', function (Blueprint $table) {
            $table->id(); // Cria a coluna 'id' como chave primária
            $table->foreignId('id_grupo_patrimonio')->constrained('grupo_patrimonios')->onDelete('cascade'); // Chave estrangeira referenciando a tabela 'grupo_patrimonios'
            $table->foreignId('id_patrimonio')->constrained('patrimonios')->onDelete('cascade'); // Chave estrangeira referenciando a tabela 'patrimonios'
            $table->string('nome'); // Nome do patrimônio
            $table->json('serie'); // Número de série do patrimônio
            $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
        });
    }

    public function down()
    {
        Schema::dropIfExists('grupo_patrimonio_items');
    }
}
