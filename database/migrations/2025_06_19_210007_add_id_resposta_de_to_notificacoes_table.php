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
        Schema::table('notificacoes', function (Blueprint $table) {
            $table->unsignedBigInteger('id_resposta_de')->nullable()->after('message');
            $table->foreign('id_resposta_de')
                ->references('id')
                ->on('notificacoes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notificacoes', function (Blueprint $table) {
            $table->dropForeign(['id_resposta_de']);
            $table->dropColumn('id_resposta_de');
        });
    }
};