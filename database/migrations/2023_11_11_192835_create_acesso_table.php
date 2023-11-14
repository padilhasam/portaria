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
        Schema::create('acesso', function (Blueprint $table) {
            $table->id();
            $table->integer('morador');
            $table->string('tipo_acesso');
            $table->string('nome');
            $table->string('cpf');
            $table->datetime('data_entrada');
            $table->datetime('tipo_saida');
            $table->string('nome_porteiro_entrada');
            $table->string('nome_porteiro_saida');
            $table->string('status_acesso');
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
