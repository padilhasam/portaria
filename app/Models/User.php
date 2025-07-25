<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";

    protected $fillable = [
        'nome',
        'documento',
        'nascimento',
        'celular',
        'user',
        'email',
        'password',
        'status',
        'tipo',
        'user_verified',
        'foto',
        'tema_escuro',
        'notificacoes',
        'idioma',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'tema_escuro' => 'boolean',
        'notificacoes' => 'boolean',
    ];

    public function notificacoesRecebidas()
    {
        return $this->belongsToMany(Notificacao::class, 'notificacao_user', 'id_user', 'id_notificacao')
            ->withPivot('read')
            ->withTimestamps();
    }

    public function notificacoesCriadas()
    {
        return $this->hasMany(Notificacao::class, 'id_criador');
    }

    public function isAdmin()
    {
        return $this->tipo === 'administrador';
    }

    public function isAtivo()
    {
        return $this->status === 'ativo';
    }

    public function isBloqueado()
    {
        return $this->status === 'bloqueado';
    }

    public function estaDeFerias()
    {
        return $this->status === 'férias';
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto
            ? asset('storage/' . $this->foto)
            : 'https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg';
    }
}
