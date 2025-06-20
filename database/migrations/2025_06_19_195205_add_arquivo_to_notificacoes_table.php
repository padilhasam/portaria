<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('notificacoes', function (Blueprint $table) {
            $table->string('arquivo')->nullable()->after('message');
        });
    }

    public function down(): void
    {
        Schema::table('notificacoes', function (Blueprint $table) {
            $table->dropColumn('arquivo');
        });
    }
};
