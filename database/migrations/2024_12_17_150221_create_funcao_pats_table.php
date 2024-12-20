<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncaoPatsTable extends Migration
{
    public function up()
    {
        Schema::create('funcao_pats', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('nome', 100)->unique(); // Nome da função
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('funcao_pats');
    }
}
