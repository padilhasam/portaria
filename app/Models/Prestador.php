<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Veiculo;

class Prestador extends Model
{
    use HasFactory;

    protected $table = 'prestadores';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'id_veiculo',  // Adicionado caso o morador tenha um veículo
        'empresa',        // nome da empresa
        'cnpj', // cnpj da empresa
        'tel_fixo',
        'email',           
        'prestador',      // funcionário que fará o serviço
        'documento', // CPF do funcionário
        'celular',  
        'acompanhante',
        'observacoes',
    ];

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'id_veiculo');
    }
}
