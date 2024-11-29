<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuloUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulo_user', function (Blueprint $table) {
            $table->id();  // Chave primária auto-incremento
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Relacionamento com a tabela de usuários
            $table->foreignId('modulo_id')->constrained('modulos')->onDelete('cascade');  // Relacionamento com a tabela de modulos
            $table->string('permissao')->default('acesso');  // Tipo de permissão (acesso, modificação, etc.)
            $table->timestamps();  // Campos de timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modulo_user');
    }
}
