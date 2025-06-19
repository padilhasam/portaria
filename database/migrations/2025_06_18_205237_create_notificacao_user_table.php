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
        Schema::create('notificacao_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_notificacao')->constrained('notificacoes')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->boolean('read')->default(false);
            $table->timestamps();

            // Evita duplicação de notificações para o mesmo usuário
            $table->unique(['id_notificacao', 'id_user']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacao_user');
    }
};
