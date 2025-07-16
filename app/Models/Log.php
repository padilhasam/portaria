<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    public $timestamps = false; // usamos 'criado_em'

    protected $fillable = [
        'id_user',
        'acao',
        'tabela_afetada',
        'registro_id',
        'descricao',
        'erro',
        'criado_em',
    ];

    public function user()
    {
        // Especificamos explicitamente que a FK é 'id_user'
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
