<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id(); // Cria uma coluna 'id' como chave primária e auto-incremento
            $table->string('id_milvus')->nullable(); // Coluna de texto que aceita valores nulos
            $table->string('id_digisac')->nullable(); // Coluna de texto que aceita valores nulos
            $table->integer('num_max_horas')->nullable(); // Coluna de inteiro que aceita valores nulos
            $table->string('id_responsavel_digisac')->nullable(); // Coluna de texto que aceita valores nulos
            $table->timestamps(); // Cria as colunas 'created_at' e 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa');
    }
}
