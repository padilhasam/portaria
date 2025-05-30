<?php

namespace app\Helpers;
use App\Models\Notificacao;

class NotificacaoHelper
{
    public static function carregarNotificacoes()
    {
        return [
            'notificacoes' => Notificacao::latest()->take(5)->get(),
            'naoLidas' => Notificacao::where('read', false)->count(),
        ];
    }
}