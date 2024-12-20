<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('relatorio_users', function (Blueprint $table) {
            // Alterar o tamanho da coluna auth_sige para permitir mais caracteres
            $table->string('auth_sige', 512)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relatorio_users', function (Blueprint $table) {
            // Reverter para o tamanho original, supondo que fosse 255
            $table->string('auth_sige', 255)->change();
        });
    }
};
