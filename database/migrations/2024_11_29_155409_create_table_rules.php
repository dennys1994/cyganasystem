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
        // Criação da tabela de roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do role (por exemplo, Admin, Professor, Aluno)
            $table->text('permissions')->nullable(); // Um campo para armazenar as permissões, pode ser uma string JSON
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_rules');
    }
};
