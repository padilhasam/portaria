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
            $table->string('nome')->nullable(false);
            $table->string('documento')->nullable(false);
            $table->string('celular')->nullable(false);
            $table->string('email');
            $table->string('empresa')->nullable(false); //razão social
            $table->string('tipo_servico')->nullable(false); //manunteção, dedetização, abastedimento gás
            $table->string('image')->nullable(false);
            $table->text('observacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestador');
    }
};
