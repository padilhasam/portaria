<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('tema_escuro')->default(false)->after('foto');
            $table->boolean('notificacoes')->default(true)->after('tema_escuro');
            $table->string('idioma', 5)->default('pt')->after('notificacoes');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tema_escuro', 'notificacoes', 'idioma']);
        });
    }
};
