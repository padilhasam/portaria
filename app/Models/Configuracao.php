<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'configuracoes';

    protected $fillable = [
        'nome_sistema',
        'email_contato',
        'logo',
        'notificacoes_email',
        'modo_manutencao',
    ];

    public $timestamps = false;

    // Opcional: Casts para garantir tipos corretos
    protected $casts = [
        'notificacoes_email' => 'boolean',
        'modo_manutencao' => 'boolean',
    ];
}
