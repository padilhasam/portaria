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
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable(false);
            $table->string('documento')->nullable(false);
            $table->date('birthdate')->nullable(false);
            $table->string('celular')->nullable(false);
            $table->string('email');
            $table->string('funcao')->nullable(false);
            $table->string('status')->nullable(false); //Ativo ou Inativo
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
        Schema::dropIfExists('funcionario');
    }
};
