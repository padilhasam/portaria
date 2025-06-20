<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Importa User para o relacionamento

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

    // Scopes
    public function scopeMaisRecentes($query)
    {
        return $query->orderByDesc('created_at');
    }

    // Relação com usuários (destinatários)
    public function destinatarios()
    {
        return $this->belongsToMany(User::class, 'notificacao_user', 'id_notificacao', 'id_user')
                    ->withPivot('read')
                    ->withTimestamps();
    }
    
    public function criador()
    {
        return $this->belongsTo(User::class, 'id_criador');
    }

        public function respostaDe()
    {
        return $this->belongsTo(Notificacao::class, 'id_resposta_de');
    }

    public function respostas()
    {
        return $this->hasMany(Notificacao::class, 'id_resposta_de');
    }
}