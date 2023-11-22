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
        Schema::create('moradores', function (Blueprint $table) {
            $table->id();
            $table->integer('id_apartamento')->nullable(false);
            $table->string('nome')->nullable(false);
            $table->string('documento')->nullable(false);
            $table->string('birthdate');
            $table->string('tel_fixo');
            $table->string('celular')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('tipo_morador')->nullable(false); //Aluguel ou Própria
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('morador');
    }
};
