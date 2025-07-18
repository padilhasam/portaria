<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Registro;
use App\Traits\Loggable;
use Exception;

class RelatorioController extends Controller
{
    use Loggable;

    public function index(Request $request)
    {
        try {
            $dataInicio = $request->input('data_inicio');
            $dataFim = $request->input('data_fim');
            $tipo = $request->input('tipo');
            $apartamento = $request->input('apartamento');

            $query = Registro::with('visitante.morador.apartamento');

            if ($dataInicio) {
                $query->whereDate('entrada', '>=', $dataInicio);
            }

            if ($dataFim) {
                $query->whereDate('saida', '<=', $dataFim);
            }

            if ($tipo) {
                $query->where('tipo_acesso', $tipo);
            }

            if ($apartamento) {
                $query->whereHas('visitante.morador.apartamento', function ($q) use ($apartamento) {
                    $q->where('numero', 'like', "%{$apartamento}%");
                });
            }

            $registros = $query->latest()->get();

            // KPIs
            $total    = $registros->count();
            $entradas = $registros->whereNotNull('entrada')->count();
            $saidas   = $registros->whereNotNull('saida')->count();
            $negados  = $registros->where('status', 'bloqueado')->count();

            $tiposAcesso = Registro::select('tipo_acesso')->distinct()->orderBy('tipo_acesso')->pluck('tipo_acesso');

            $this->registrarLog('READ', 'relatorios', null, "Relatório visualizado com filtros: início={$dataInicio}, fim={$dataFim}, tipo={$tipo}, apto={$apartamento}");

            return view('pages.relatorios.index', compact('registros', 'total', 'entradas', 'saidas', 'negados', 'tiposAcesso'));
        } catch (Exception $e) {
            $this->registrarLog('ERROR', 'relatorios', null, "Erro ao carregar relatório", $e->getMessage());
            return back()->with('error', 'Erro ao carregar relatório.');
        }
    }

    private function filtrarRegistros(Request $request)
    {
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');
        $tipo = $request->input('tipo');
        $apartamento = $request->input('apartamento');

        $query = Registro::with('visitante.morador.apartamento');

        if ($dataInicio) {
            $query->whereDate('entrada', '>=', $dataInicio);
        }

        if ($dataFim) {
            $query->whereDate('saida', '<=', $dataFim);
        }

        if ($tipo) {
            $query->where('tipo_acesso', $tipo);
        }

        if ($apartamento) {
            $query->whereHas('visitante.morador.apartamento', function ($q) use ($apartamento) {
                $q->where('numero', 'like', "%{$apartamento}%");
            });
        }

        return $query->latest()->get();
    }

    public function export(Request $request)
    {
        try {
            $registros = $this->filtrarRegistros($request);

            $this->registrarLog('EXPORT', 'relatorios', null, "Relatório exportado em CSV com " . $registros->count() . " registros.");

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="relatorio-acessos.csv"',
            ];

            $callback = function () use ($registros) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, ['ID', 'Tipo', 'Data/Hora', 'Apartamento']);

                foreach ($registros as $registro) {
                    fputcsv($handle, [
                        $registro->id,
                        ucfirst($registro->tipo_acesso),
                        $registro->created_at->format('d/m/Y H:i'),
                        $registro->visitante->morador->apartamento->numero ?? '—',
                    ]);
                }

                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);
        } catch (Exception $e) {
            $this->registrarLog('ERROR', 'relatorios', null, "Erro ao exportar CSV", $e->getMessage());
            return back()->with('error', 'Erro ao exportar relatório em CSV.');
        }
    }

    public function exportPdf(Request $request)
    {
        try {
            $registros = $this->filtrarRegistros($request);

            $this->registrarLog('EXPORT', 'relatorios', null, "Relatório exportado em PDF com " . $registros->count() . " registros.");

            $pdf = Pdf::loadView('pages.relatorios.pdf', compact('registros'));

            return $pdf->download('relatorio-acessos.pdf');
        } catch (Exception $e) {
            $this->registrarLog('ERROR', 'relatorios', null, "Erro ao exportar PDF", $e->getMessage());
            return back()->with('error', 'Erro ao exportar relatório em PDF.');
        }
    }

     public function dadosGraficos(Request $request)
    {
        $dataInicio = $request->input('data_inicio') ?? now()->startOfYear();
        $dataFim = $request->input('data_fim') ?? now()->endOfYear();

        // Função para preencher todos os 12 meses com 0 se não houver registro
        $preencherMeses = function ($dados) {
            $dadosArray = is_array($dados) ? $dados : $dados->toArray();
            $result = [];
            for ($m = 1; $m <= 12; $m++) {
                $result[$m] = (int) ($dadosArray[$m] ?? 0);
            }
            return $result;
        };

        // Acessos
        $acessosPorMes = $preencherMeses(
            Registro::whereBetween('entrada', [$dataInicio, $dataFim])
                ->selectRaw('MONTH(entrada) as mes, COUNT(*) as total')
                ->groupBy('mes')->orderBy('mes')->pluck('total', 'mes')
        );

        // Usuários Ativos
        $usuariosAtivos = $preencherMeses(
            Registro::whereBetween('entrada', [$dataInicio, $dataFim])
                ->selectRaw('MONTH(entrada) as mes, COUNT(DISTINCT id_visitante) as total')
                ->groupBy('mes')->orderBy('mes')->pluck('total', 'mes')
        );

        // Entradas por Tipo
        $entradasPorTipo = Registro::whereBetween('entrada', [$dataInicio, $dataFim])
            ->selectRaw('tipo_acesso, COUNT(*) as total')
            ->groupBy('tipo_acesso')->pluck('total', 'tipo_acesso');

        // Entradas x Saídas
        $entradasPorMes = $preencherMeses(
            Registro::where('tipo_acesso', 'entrada')
                ->whereBetween('entrada', [$dataInicio, $dataFim])
                ->selectRaw('MONTH(entrada) as mes, COUNT(*) as total')
                ->groupBy('mes')->pluck('total', 'mes')
        );

        $saidasPorMes = $preencherMeses(
            Registro::where('tipo_acesso', 'saida')
                ->whereBetween('saida', [$dataInicio, $dataFim])
                ->selectRaw('MONTH(saida) as mes, COUNT(*) as total')
                ->groupBy('mes')->pluck('total', 'mes')
        );

        return response()->json([
            'acessos' => $acessosPorMes,
            'usuarios' => $usuariosAtivos,
            'entradas' => $entradasPorTipo,
            'entrada_saida' => [
                'entradas' => $entradasPorMes,
                'saidas' => $saidasPorMes
            ],
        ]);
    }
}
