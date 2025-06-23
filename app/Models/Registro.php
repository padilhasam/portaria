<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $table = 'registros';

    protected $fillable = [
        'id_visitante',   // FK para visitante
        'tipo_acesso',    // entrada, saida, etc
        'observacoes',
        'entrada',        // datetime
        'saida',          // datetime
        'veiculo',
        'placa',
        'empresa',
        'img',
        // outros campos que achar necessário
    ];

    protected $casts = [
        'entrada' => 'datetime',
        'saida' => 'datetime',
    ];

    public function visitante()
    {
        return $this->belongsTo(Visitante::class, 'id_visitante');
    }
}
