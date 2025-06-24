<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    // Caso a tabela não seja "logs", defina aqui
    // protected $table = 'nome_da_tabela_de_logs';

    protected $fillable = [
        'nivel',    // Exemplo: INFO, ERRO, WARNING
        'mensagem', // Texto do log
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}