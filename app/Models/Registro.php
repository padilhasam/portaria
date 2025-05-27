<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $table = 'registros';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'documento',
        'empresa',
        'veiculo',
        'placa',
        'img', // nome da imagem salva
        'tipo_acesso',
        'observacoes',
        'entrada',
        'saida',
        'id_visitante' // adicionado aqui
    ];

    public function visitante()
    {
        return $this->belongsTo(Visitante::class, 'id_visitante');
    }
    
}
