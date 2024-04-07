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
        'nome',
        'foto',
        'documento',
        'empresa',
        'veiculo',
        'placa',
        'tipo_morador',
        'tipo_acesso',
        'local_descricao',
        'observacao',
        'nome_porteiro_entrada',
        'nome_porteiro_saida',
    ];
}
