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
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('documento')->nullable();
            $table->string('empresa')->nullable();
            $table->string('veiculo')->nullable();
            $table->string('placa')->nullable();
            $table->string('foto')->nullable();
            $table->string('tipo_morador')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamp('entrada')->nullable();
            $table->timestamp('saida')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};