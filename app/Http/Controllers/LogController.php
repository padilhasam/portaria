<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArrayExport;
use Carbon\Carbon;

class LogController extends Controller
{
    /**
     * Lista os logs com filtros e paginação.
     */
    public function index(Request $request)
    {
        $logs = $this->filtrarLogs($request, false);
        return view('pages.logs.index', compact('logs'));
    }

    /**
     * Exporta logs em PDF, CSV ou TXT.
     */
    public function gerar(Request $request)
    {
        $logs = $this->filtrarLogs($request, true);

        try {
            return match ($request->tipo) {
                'txt' => $this->gerarTxt($logs),
                'csv' => $this->gerarCsv($logs),
                default => $this->gerarPdf($logs),
            };
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao gerar logs: ' . $e->getMessage());
        }
    }

    /**
     * Filtra os logs de acordo com os parâmetros enviados.
     * $retornoCompleto = true => retorna todos os registros; false => paginação.
     */
    private function filtrarLogs(Request $request, bool $retornoCompleto = false)
    {
        $query = Log::query()
            ->with('user') // evita N+1 ao carregar o usuário
            ->when($request->usuario, function ($query, $usuario) {
                $query->whereHas('user', function ($q) use ($usuario) {
                    $q->where('nome', 'like', "%{$usuario}%");
                    // ⬆️ Corrigido para usar "nome" (seguindo sua tabela usuarios)
                });
            })
            ->when($request->acao, fn($query, $acao) => $query->where('acao', $acao))
            ->when($request->nivel, function ($query, $nivel) {
                if ($nivel === 'ERRO') {
                    $query->whereNotNull('erro');
                } elseif (in_array($nivel, ['INFO', 'WARNING'])) {
                    $query->where('acao', $nivel);
                }
            })
            ->when($request->data, fn($query, $data) => $query->whereDate('criado_em', $data))
            ->when($request->data_inicio && $request->data_fim, function ($query) use ($request) {
                $inicio = Carbon::parse($request->data_inicio)->startOfDay();
                $fim = Carbon::parse($request->data_fim)->endOfDay();
                $query->whereBetween('criado_em', [$inicio, $fim]);
            })
            ->orderBy('criado_em', 'desc');

        return $retornoCompleto ? $query->get() : $query->paginate(20);
    }

    /**
     * Gera o arquivo PDF.
     */
    private function gerarPdf($logs)
    {
        $pdf = Pdf::loadView('pages.logs.exportar_pdf', compact('logs'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('logs_' . now()->format('Y-m-d_H-i') . '.pdf');
    }

    /**
     * Gera o arquivo CSV.
     */
    private function gerarCsv($logs)
    {
        $dados = $logs->map(function ($log) {
            return [
                'Usuário' => $log->user?->nome ?? '-', // ⬅️ Corrigido para usar "nome"
                'Ação' => $log->acao,
                'Tabela' => $log->tabela_afetada,
                'Registro' => $log->registro_id ?? '-',
                'Descrição' => $log->descricao,
                'Erro' => $log->erro ?? '-',
                'Data/Hora' => $log->criado_em instanceof Carbon
                    ? $log->criado_em->format('d/m/Y H:i:s')
                    : Carbon::parse($log->criado_em)->format('d/m/Y H:i:s'),
            ];
        });

        return Excel::download(
            new ArrayExport($dados->toArray()),
            'logs_' . now()->format('Y-m-d_H-i') . '.csv'
        );
    }

    /**
     * Gera o arquivo TXT.
     */
    private function gerarTxt($logs)
    {
        $conteudo = "===== LOGS DO SISTEMA =====\n\n";
        foreach ($logs as $log) {
            $conteudo .= "Usuário: " . ($log->user?->nome ?? '-') . "\n"; // ⬅️ Corrigido para "nome"
            $conteudo .= "Ação: {$log->acao}\n";
            $conteudo .= "Tabela: {$log->tabela_afetada}\n";
            $conteudo .= "Registro: " . ($log->registro_id ?? '-') . "\n";
            $conteudo .= "Descrição: {$log->descricao}\n";
            $conteudo .= "Erro: " . ($log->erro ?? '-') . "\n";
            $conteudo .= "Data/Hora: " . (
                $log->criado_em instanceof Carbon
                    ? $log->criado_em->format('d/m/Y H:i:s')
                    : Carbon::parse($log->criado_em)->format('d/m/Y H:i:s')
            ) . "\n";
            $conteudo .= "-----------------------------------\n";
        }

        return response($conteudo)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename=logs_' . now()->format('Y-m-d_H-i') . '.txt');
    }
}
