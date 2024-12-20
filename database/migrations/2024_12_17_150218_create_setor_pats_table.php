<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetorPatsTable extends Migration
{
    public function up()
    {
        Schema::create('setor_pats', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('nome', 100)->unique(); // Nome do setor
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('setor_pats');
    }
}
