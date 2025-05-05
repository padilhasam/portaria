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
        Schema::table('moradores', function (Blueprint $table) {
            $table->unsignedBigInteger('id_veiculo')->nullable()->after('id_apartamento'); // Adiciona a coluna id_veiculo
            $table->foreign('id_veiculo')->references('id')->on('veiculos')->onDelete('set null'); // Adiciona a chave estrangeira
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('moradores', function (Blueprint $table) {
            $table->dropForeign(['id_veiculo']); // Remove a chave estrangeira
            $table->dropColumn('id_veiculo'); // Remove a coluna id_veiculo
        });
    }
};