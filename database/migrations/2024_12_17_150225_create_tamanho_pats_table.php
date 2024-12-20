<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTamanhoPatsTable extends Migration
{
    public function up()
    {
        Schema::create('tamanho_pats', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('tamanho', 50); // Tamanho do patrimônio
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tamanho_pats');
    }
}
