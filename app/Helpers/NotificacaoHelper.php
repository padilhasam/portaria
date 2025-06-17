<?php

namespace App\Helpers;

use App\Models\Notificacao;

class NotificacaoHelper
{
    public static function carregarNotificacoes()
    {
        $naoLidas = Notificacao::where('read', false)
            ->latest()
            ->take(5)
            ->get();

        return [
            'notificacoes' => $naoLidas,
            'naoLidas' => $naoLidas->count(),
        ];
    }
}