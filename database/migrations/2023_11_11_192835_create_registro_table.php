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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable(false);
            $table->string('foto')->nullable(true);
            $table->string('documento')->nullable(false);
            $table->string('empresa')->nullable(true);
            $table->string('veiculo')->nullable(true);
            $table->string('placa')->nullable(true);
            $table->string('tipo_morador')->nullable(true);
            $table->string('tipo_acesso');
            $table->string('local_descricao');
            $table->string('observacao');
            $table->string('nome_porteiro_entrada')->nullable(true);
            $table->string('nome_porteiro_saida')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
