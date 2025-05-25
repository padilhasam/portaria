<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;


    protected $table = 'veiculos';

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'placa',
        'tipo',
        'marca',
        'modelo',
        'cor',
        'observacoes'
    ];
}
