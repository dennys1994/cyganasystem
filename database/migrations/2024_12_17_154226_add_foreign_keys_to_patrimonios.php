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
            // Adicionando as colunas de chave estrangeira
            $table->unsignedBigInteger('setor_pat_id')->nullable();
            $table->unsignedBigInteger('funcao_pat_id')->nullable();
            $table->unsignedBigInteger('tamanho_pat_id')->nullable();

            // Adicionando as chaves estrangeiras
            $table->foreign('setor_pat_id')->references('id')->on('setor_pats')->onDelete('set null');
            $table->foreign('funcao_pat_id')->references('id')->on('funcao_pats')->onDelete('set null');
            $table->foreign('tamanho_pat_id')->references('id')->on('tamanho_pats')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patrimonios', function (Blueprint $table) {
            // Remover as chaves estrangeiras
            $table->dropForeign(['setor_pat_id']);
            $table->dropForeign(['funcao_pat_id']);
            $table->dropForeign(['tamanho_pat_id']);

            // Remover as colunas
            $table->dropColumn(['setor_pat_id', 'funcao_pat_id', 'tamanho_pat_id']);
        });
    }
};
