<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_grupo_patrimonios_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrupoPatrimoniosTable extends Migration
{
    public function up()
    {
        Schema::create('grupo_patrimonios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');                // Nome do grupo de patrimônio
            $table->json('patrimonios');            // IDs dos patrimônios (como um array JSON)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('grupo_patrimonios');
    }
}

