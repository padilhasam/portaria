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
        Schema::create('apartamento', function (Blueprint $table) {
            $table->id('id_apartamento');
            $table->string('numero')->nullable(false);
            $table->string('bloco')->nullable(false);
            $table->string('vaga')->nullable(false); //Número da vaga do estacionamento
            $table->string('status_vaga')->nullable(false); //Ocupada, Livre, Emprestada, Alugada
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartamento');
    }
};
