<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartamento extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'numero',
        'bloco',
        'ramal',
        'vaga',
        'status_vaga'
    ];
    

    // public $rules = [
    //     'bloco' => 'string|max:2',
    //     'numero' => 'string|max:4'
    // ];
}
