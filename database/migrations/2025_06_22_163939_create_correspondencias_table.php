<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('correspondencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_morador')->constrained()->onDelete('cascade');
            $table->string('tipo'); // Ex: Carta, Encomenda, Pacote
            $table->string('remetente')->nullable(); // Nome da transportadora ou pessoa
            $table->timestamp('recebida_em')->default(now());
            $table->timestamp('entregue_em')->nullable();
            $table->text('observacoes')->nullable();
            $table->enum('status', ['Recebida', 'Entregue'])->default('Recebida');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correspondencias');
    }
};
