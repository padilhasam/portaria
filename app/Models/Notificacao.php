<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Notificacao extends Model
{
    use HasFactory;

    protected $table = 'notificacoes';

    protected $fillable = [
        'id_criador',
        'id_resposta_de',
        'title', 
        'message',
        'arquivo',
    ];

    /**
     * Scope para retornar notificações mais recentes primeiro
     */
    public function scopeMaisRecentes($query)
    {
        return $query->orderByDesc('created_at');
    }

    /**
     * Relação: muitos para muitos com usuários (destinatários)
     */
    public function destinatarios()
    {
        return $this->belongsToMany(User::class, 'notificacao_user', 'id_notificacao', 'id_user')
                    ->withPivot('read')
                    ->withTimestamps();
    }

    /**
     * Relação: criador da notificação (usuário)
     */
    public function criador()
    {
        return $this->belongsTo(User::class, 'id_criador');
    }

    /**
     * Relação: esta notificação é resposta de outra?
     */
    public function respostaDe()
    {
        return $this->belongsTo(Notificacao::class, 'id_resposta_de');
    }

    /**
     * Relação: esta notificação possui respostas
     */
    public function respostas()
    {
        return $this->hasMany(Notificacao::class, 'id_resposta_de');
    }

    public function scopeFiltrarPorCriador($query, $id)
    {
        return $query->where('id_criador', $id);
    }

    public function isResposta()
    {
        return !is_null($this->id_resposta_de);
    }

    public function temAnexo(): bool
    {
        return !empty($this->arquivo);
    }

    public function foiLidaPor(User $user): bool
    {
        return $this->destinatarios()
                    ->where('id_user', $user->id)
                    ->wherePivot('read', true)
                    ->exists();
    }

}