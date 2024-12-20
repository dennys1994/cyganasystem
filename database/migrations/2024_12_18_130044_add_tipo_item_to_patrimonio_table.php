<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patrimonios', function (Blueprint $table) {
            $table->enum('tipo_patrimonio', ['01', '02'])->default('01');  // Equipamento como valor padrão
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patrimonios', function (Blueprint $table) {
            $table->dropColumn('tipo_patrimonio');
        });
    }
};
