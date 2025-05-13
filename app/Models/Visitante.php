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
        'id_veiculo',  // Agora é id_veiculo, que é a chave estrangeira
        'image', // nome da imagem salva
        'tipo_acesso',
        'observacoes',
        'entrada',
        'saida',
    ];

    /**
     * Relacionamento com o modelo Veiculo
     */
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'id_veiculo'); // 'id_veiculo' é a chave estrangeira
    }
}