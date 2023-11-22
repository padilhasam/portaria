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
        'birthdate',
        'tel_fixo',
        'celular',
        'email',
        'tipo_morador',
        'image'
    ];

}
