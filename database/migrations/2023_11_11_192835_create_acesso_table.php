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
            $table->integer('id_visitante'); // id_visitante e também id_prestador ???????
            $table->string('nome')->nullable(false);
            $table->string('documento')->nullable(false);
            $table->string('tipo_acesso');
            $table->datetime('data_acesso')->nullable(false);
            $table->time('hora_entrada')->nullable(false);
            $table->time('hora_saida')->nullable(false);
            $table->string('nome_porteiro_entrada')->nullable(false);
            $table->string('nome_porteiro_saida')->nullable(false);
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
