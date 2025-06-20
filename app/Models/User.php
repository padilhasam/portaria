<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany notificacoesRecebidas()
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'documento',
        'nascimento',
        'celular',
        'user',
        'email',
        'password',
        'acesso_tipo',
        'user_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        //'password' => 'hashed',
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
}
