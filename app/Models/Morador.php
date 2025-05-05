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

    /**
     * Acessor para pegar o bloco do apartamento
     */
    public function getBlocoAttribute()
    {
        return $this->apartamento ? $this->apartamento->bloco : null;
    }

    /**
     * Acessor para pegar o ramal do apartamento
     */
    public function getRamalAttribute()
    {
        return $this->apartamento ? $this->apartamento->ramal : null;
    }
}