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
        Schema::table('visitantes', function (Blueprint $table) {
            $table->unsignedBigInteger('id_prestador')->nullable()->after('id_veiculo'); // Adiciona a coluna id_morador
            $table->foreign('id_prestador')->references('id')->on('prestadores')->onDelete('set null'); // Adiciona a chave estrangeira
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitantes', function (Blueprint $table) {
            $table->dropForeign(['id_prestador']); // Remove a chave estrangeira
            $table->dropColumn('id_prestador'); // Remove a coluna id_veiculo
        });
    }
};