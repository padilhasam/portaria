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
        Schema::create('acessos', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable(false);
            $table->string('nome')->nullable(true);
            $table->string('documento')->nullable(true);
            $table->string('tipo_morador')->nullable(true);
            $table->string('empresa')->nullable(true);
            $table->string('veiculo')->nullable(true);
            $table->string('placa')->nullable(true);
            $table->string('tipo_acesso');
            $table->string('nome_porteiro_entrada')->nullable(true);
            $table->string('nome_porteiro_saida')->nullable(true);
            $table->string('status_acesso')->nullable(false); //Ativo, Inativo, Liberado, Bloqueado
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acesso');
    }
};
