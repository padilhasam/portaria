<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();

            // FK para usuário responsável pela ação
            $table->foreignId('id_user')->nullable()->constrained('users')->onDelete('cascade');

            $table->string('acao');              // CREATE, UPDATE, DELETE, INFO, WARNING, ERRO etc.
            $table->string('tabela_afetada')->nullable();
            $table->unsignedBigInteger('registro_id')->nullable();
            $table->text('descricao')->nullable();
            $table->text('erro')->nullable();

            $table->timestamp('criado_em')->useCurrent();

            // Caso queira, pode adicionar índice para filtros rápidos
            $table->index('acao');
            $table->index('criado_em');
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs');
    }
};
