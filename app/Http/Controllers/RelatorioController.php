<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registro;

class RelatorioController extends Controller
{
    public function index(Request $request)
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

        $registros = $query->latest()->get();

        // KPIs
        $total = $registros->count();
        $entradas = $registros->where('tipo_acesso', 'entrada')->count();
        $saidas = $registros->where('tipo_acesso', 'saida')->count();
        $negados = $registros->where('status', 'negado')->count(); // Se existir

        return view('pages.relatorios.index', compact('registros', 'total', 'entradas', 'saidas', 'negados'));
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
        $registros = $this->filtrarRegistros($request);

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
    }
}
