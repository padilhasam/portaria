<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    use HasFactory;

    protected $table = 'visitantes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'documento',
        'telefone',
        'empresa',
        'veiculo',
        'placa',
        'image', // nome da imagem salva
        'tipo_acesso',
        'observacoes',
        'entrada',
        'saida'
    ];

}
