<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGrupoPatrimoniosTable extends Migration
{
    public function up()
    {
        Schema::table('grupo_patrimonios', function (Blueprint $table) {
            $table->unsignedBigInteger('id_setor')->after('id'); // FK para setor_pats
            $table->string('estado')->default('Disponível')->after('nome'); // Novo estado padrão
            $table->dropColumn('patrimonios'); // Remover a coluna JSON

            $table->foreign('id_setor')->references('id')->on('setor_pats')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('grupo_patrimonios', function (Blueprint $table) {
            $table->json('patrimonios')->nullable();
            $table->dropForeign(['id_setor']);
            $table->dropColumn('id_setor');
            $table->dropColumn('estado');
        });
    }
}
