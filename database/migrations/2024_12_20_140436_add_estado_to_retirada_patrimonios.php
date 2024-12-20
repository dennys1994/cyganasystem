<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoToRetiradaPatrimonios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retirada_patrimonios', function (Blueprint $table) {
            $table->string('estado')->nullable(); // Adiciona a coluna 'estado'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('retirada_patrimonios', function (Blueprint $table) {
            $table->dropColumn('estado'); // Remove a coluna 'estado'
        });
    }
}
