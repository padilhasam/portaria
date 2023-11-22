<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortariaRegistro extends Model
{
    use HasFactory;

    protected $table = 'acessos';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'foto',
        'nome',
        'documento',
        'tipo_morador',
        'empresa',
        'veiculo',
        'placa',
        'tipo_acesso',
        'nome_porteiro_entrada',
        'nome_porteiro_saida',
        'status_acesso'
    ];
}
