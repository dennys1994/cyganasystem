<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetiradaPatrimoniosTable extends Migration
{
    public function up()
    {
        Schema::create('retirada_patrimonios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user_resp')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('id_user_tec')->nullable()->constrained('users')->onDelete('set null');
            $table->json('patrimonios')->nullable();
            $table->json('grupos')->nullable();
            $table->longText('anotacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('retirada_patrimonios');
    }
}

