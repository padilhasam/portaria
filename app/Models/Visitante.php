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
        'id_veiculo',  // Agora é id_veiculo, que é a chave estrangeira
        'id_prestador',
        'nome',
        'documento',
        'celular',
        'empresa',
        'image', // nome da imagem salva
        'observacoes',
    ];

    /**
     * Relacionamento com o modelo Veiculo
     */
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class, 'id_veiculo'); // 'id_veiculo' é a chave estrangeira
    }

    /**
     * Relacionamento com o modelo Prestador
     */
    public function prestador()
    {
        return $this->belongsTo(Prestador::class, 'id_prestador');
    }

    /**
     * Relacionamento com o modelo Registro
     */
        public function registros()
    {
        return $this->hasMany(Registro::class, 'id_visitante');
    }

    /**
     * Relacionamento com o modelo Morador
     */
        public function morador()
    {
        return $this->belongsTo(Morador::class, 'id_morador');
    }
}
