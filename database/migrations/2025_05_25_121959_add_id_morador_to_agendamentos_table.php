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
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_morador')->nullable()->after('id_usuario');; // Adiciona a coluna id_morador
            $table->foreign('id_morador')->references('id')->on('moradores')->onDelete('set null'); // Adiciona a chave estrangeira
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->dropForeign(['id_morador']); // Remove a chave estrangeira
            $table->dropColumn('id_morador'); // Remove a coluna id_veiculo
        });
    }
};
