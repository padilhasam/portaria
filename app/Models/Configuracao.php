<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'configuracoes';

    protected $fillable = [
        // liste aqui os campos que podem ser preenchidos em massa
        'chave', 'valor',
    ];

    public $timestamps = false; // se não tiver timestamps
}
