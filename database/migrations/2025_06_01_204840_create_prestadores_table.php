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
        Schema::create('prestadores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_veiculo')->nullable(); // Corrigido para permitir NULL
            $table->string('empresa');
            $table->string('cnpj');
            $table->string('tel_fixo')->nullable();
            $table->string('email');
            $table->string('prestador');
            $table->string('documento');
            $table->string('celular')->nullable();
            $table->string('acompanhante')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();

            // Foreign Key com ON DELETE SET NULL
            $table->foreign('id_veiculo')->references('id')->on('veiculos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestadores');
    }
};
