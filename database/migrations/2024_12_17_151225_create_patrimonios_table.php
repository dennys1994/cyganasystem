<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatrimoniosTable extends Migration
{
    public function up()
    {
        Schema::create('patrimonios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();  // Código do patrimônio
            $table->string('nome_abv');            // Nome abv patrimônio
            $table->string('nome_completo');      // Nome completo do patrimônio
            $table->json('series');              // Séries do patrimônio (como um array JSON)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patrimonios');
    }
}
