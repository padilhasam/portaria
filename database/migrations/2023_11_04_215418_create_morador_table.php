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
            $table->unsignedBigInteger('id_apartamento');
            $table->string('nome');
            $table->string('documento');
            $table->date('nascimento');
            $table->string('tel_fixo')->nullable();
            $table->string('celular');
            $table->string('email');
            $table->string('tipo_morador');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moradores');
    }
};
