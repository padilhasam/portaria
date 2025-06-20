<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class NotificacaoHelper
{
    public static function carregarNotificacoes()
    {
        $user = Auth::user();

        if (!$user) {
            return [
                'notificacoes' => collect(),
                'naoLidas' => 0,
            ];
        }

        // Carregar últimas 5 notificações não lidas, ordenadas por data do pivot
        $notificacoes = $user->notificacoesRecebidas()
            ->wherePivot('read', false)
            ->orderByPivot('created_at', 'desc') // mais seguro
            ->take(5)
            ->get();

        // Número total de não lidas
        $naoLidas = $user->notificacoesRecebidas()
            ->wherePivot('read', false)
            ->count();

        return [
            'notificacoes' => $notificacoes,
            'naoLidas' => $naoLidas,
        ];
    }

    public function notificacoesNaoLidas()
    {
        return $this->notificacoesRecebidas()->wherePivot('read', false);
    }
}