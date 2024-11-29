<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_xx_xx_xxxxxx_create_faixas_precos_table.php
    public function up()
    {
        Schema::create('faixas_precos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias_margem')->onDelete('cascade');
            $table->decimal('min', 10, 2); // Faixa de preço mínima
            $table->decimal('max', 10, 2); // Faixa de preço máxima
            $table->decimal('avista', 5, 2); // Percentual à vista
            $table->decimal('parcelado', 5, 2); // Percentual parcelado
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('faixas_precos');
    }

};
