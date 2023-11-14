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
        Schema::create('servico', function (Blueprint $table) {
            $table->id();
            $table->integer('id_visitante');
            $table->string('funcionario');
            $table->string('empresa_executante');
            $table->string('tipo');
            $table->timestamp('data');
            $table->timestamp('entrada');
            $table->timestamp('saida');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servico');
    }
};
