<?php

namespace App\Services;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogService
{
    /**
     * Registra um log no sistema.
     *
     * @param string $acao       Ação realizada (CREATE, UPDATE, DELETE, ERRO, INFO, WARNING)
     * @param string|null $tabela Nome da tabela afetada (ex: 'users')
     * @param int|null $registroId ID do registro afetado
     * @param string|null $descricao Descrição detalhada do log
     * @param string|null $erro   Mensagem de erro, se existir
     * @return Log
     */
    public static function registrar(
        string $acao,
        ?string $tabela = null,
        ?int $registroId = null,
        ?string $descricao = null,
        ?string $erro = null
    ): Log {
        return Log::create([
            'id_user' => Auth::id(),
            'acao' => strtoupper($acao),
            'tabela_afetada' => $tabela,
            'registro_id' => $registroId,
            'descricao' => $descricao,
            'erro' => $erro,
            'criado_em' => now(),
        ]);
    }
}
