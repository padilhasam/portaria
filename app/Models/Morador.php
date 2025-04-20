<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Morador extends Model
{
    use HasFactory;

    protected $table = 'moradores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_apartamento',
        'bloco',
        'nome',
        'documento',
        'nascimento',
        'tel_fixo',
        'celular',
        'email',
        'tipo_morador',
        'id_veiculo',  // Adicionado caso o morador tenha um veículo
    ];

    /**
     * Relacionamento com o modelo Veiculo
     */
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'id_veiculo');
    }

    /**
     * Relacionamento com o modelo Apartamento
     */
    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class, 'id_apartamento');
    }
}
