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
        Schema::create('taxas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bandeira_id')->constrained('bandeiras'); // Relaciona com a tabela bandeiras
            $table->integer('parcelas');
            $table->decimal('percentual', 5, 2); // Taxa percentual
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxas');
    }
};
