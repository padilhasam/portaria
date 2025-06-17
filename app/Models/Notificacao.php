<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    use HasFactory;

    protected $table = 'notificacoes';

    protected $fillable = [
        'title', 
        'message', 
        'read',
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    public $timestamps = true; // ou false, se não usa

    // Scopes
    public function scopeNaoLidas($query)
    {
        return $query->where('read', false);
    }

    public function scopeLidas($query)
    {
        return $query->where('read', true);
    }

    public function scopeMaisRecentes($query)
    {
        return $query->orderByDesc('created_at');
    }

    // Ações
    public function marcarComoLida()
    {
        $this->update(['read' => true]);
    }
}