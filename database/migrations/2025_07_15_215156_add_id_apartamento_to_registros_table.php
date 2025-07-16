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
            $table->unsignedBigInteger('id_apartamento')->nullable()->after('id_visitante'); // Adiciona a coluna id_apartamento
            $table->foreign('id_apartamento')->references('id')->on('apartamentos')->onDelete('set null'); // Adiciona a chave estrangeira
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registros', function (Blueprint $table) {
            $table->dropForeign(['id_apartamento']); // Remove a chave estrangeira
            $table->dropColumn('id_apartamento'); // Remove a coluna id_apartamento
        });
    }
};
