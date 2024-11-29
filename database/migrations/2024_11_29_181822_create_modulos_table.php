<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->id();  // Chave primária auto-incremento
            $table->string('nome');  // Nome do módulo
            $table->text('descricao')->nullable();  // Descrição do módulo
            $table->boolean('ativo')->default(true);  // Módulo ativo ou não
            $table->timestamps();  // Campos de timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modulos');
    }
}
