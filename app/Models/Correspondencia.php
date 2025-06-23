<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correspondencia extends Model
{
    use HasFactory;

    protected $table = 'correspondencias';

    protected $fillable = [
        'id_morador',
        'tipo',
        'remetente',
        'recebida_em',
        'entregue_em',
        'observacoes',
        'status'
    ];

    public function morador()
    {
        return $this->belongsTo(Morador::class);
    }
}
