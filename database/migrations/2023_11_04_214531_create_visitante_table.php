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
        Schema::create('visitante', function (Blueprint $table) {
            $table->id('id_visitante');
            $table->string('nome')->nullable(false);
            $table->string('documento')->nullable(false);
            $table->string('telefone')->nullable(false);
            $table->string('image')->nullable(false);
            $table->string('observacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitante');
    }
};
