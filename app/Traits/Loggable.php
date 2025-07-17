<?php

namespace App\Traits;

use App\Models\Log;

trait Loggable
{
    /**
     * Registra um log no sistema
     *
     * @param string $acao          CREATE | UPDATE | DELETE | etc.
     * @param string $tabela        Nome da tabela afetada
     * @param int|null $registro_id ID do registro afetado (pode ser null em caso de erro)
     * @param string $descricao     Descrição do que aconteceu
     * @param string|null $erro     Mensagem de erro (caso exista)
     */
    public function registrarLog(string $acao, string $tabela, ?int $registro_id, string $descricao, ?string $erro = null)
    {
        Log::create([
            'id_user'        => auth()->id(),
            'acao'           => strtoupper($acao),
            'tabela_afetada' => $tabela,
            'registro_id'    => $registro_id,
            'descricao'      => $descricao,
            'erro'           => $erro,
            'criado_em'      => now(),
        ]);
    }
}
