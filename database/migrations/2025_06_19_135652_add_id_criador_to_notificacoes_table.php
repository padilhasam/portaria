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
            $table->foreignId('id_criador')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('notificacoes', function (Blueprint $table) {
            $table->dropForeign(['id_criador']);
            $table->dropColumn('id_criador');
        });
    }
};
