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
        Schema::table('registros', function (Blueprint $table) {
            $table->unsignedBigInteger('id_visitante')->nullable()->after('id'); // Adiciona a coluna id_morador
            $table->foreign('id_visitante')->references('id')->on('visitantes')->onDelete('set null'); // Adiciona a chave estrangeira
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registros', function (Blueprint $table) {
            $table->dropForeign(['id_visitante']); // Remove a chave estrangeira
            $table->dropColumn('id_visitante'); // Remove a coluna id_veiculo
        });
    }
};

