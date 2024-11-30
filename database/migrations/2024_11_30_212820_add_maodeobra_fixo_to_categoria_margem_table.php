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
        Schema::table('categorias_margem', function (Blueprint $table) {
            $table->decimal('maodeobra_fixo', 10, 2)->default(0)->after('nome'); // Ajuste conforme a estrutura
        });
    }

    public function down()
    {
        Schema::table('categorias_margem', function (Blueprint $table) {
            $table->dropColumn('maodeobra_fixo');
        });
    }

};
