<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\Visitante;
use App\Models\Apartamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\Loggable;
use Exception;

class RegistroController extends Controller
{
    use Loggable;

    public function index(Request $request)
    {
        // $query = Registro::with('visitante')->orderBy('entrada', 'desc');
        // $query = Registro::with('visitante')->orderBy('created_at', 'desc');

        $query = Registro::with('visitante')
        ->orderByRaw("
            CASE
                WHEN status = 'liberado' AND saida IS NULL THEN 1  -- Ativos primeiro
                WHEN status = 'liberado' AND saida IS NOT NULL THEN 2 -- Finalizados depois
                WHEN status = 'bloqueado' THEN 3 -- Bloqueados por último
                ELSE 4 -- Caso apareça algum status diferente
            END
        ")
        ->orderBy('created_at', 'desc'); // Dentro de cada grupo, mais recentes primeiro

        if ($request->filled('entrada_inicio')) {
            $query->whereDate('entrada', '>=', $request->entrada_inicio);
        }

        if ($request->filled('entrada_fim')) {
            $query->whereDate('entrada', '<=', $request->entrada_fim);
        }

        if ($request->filled('visitante_id')) {
            $query->where('id_visitante', $request->visitante_id);
        }

        if ($request->filled('tipo')) {
            if ($request->tipo === 'entrada') {
                $query->whereNotNull('entrada')->whereNull('saida');
            } elseif ($request->tipo === 'saida') {
                $query->whereNotNull('saida');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('documento', 'like', "%{$search}%")
                  ->orWhere('empresa', 'like', "%{$search}%")
                  ->orWhere('placa', 'like', "%{$search}%")
                  ->orWhere('veiculo', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registros = $query->paginate(10);

        $totalAcessos = Registro::count();
        $entradasHoje = Registro::whereDate('entrada', Carbon::today())->count();
        $saidasHoje = Registro::whereDate('saida', Carbon::today())->count();
        $acessosBloqueados = Registro::where('status', 'bloqueado')->count();

        $visitantes = Visitante::orderBy('nome')->get();

        return view('pages.registros.index', compact(
            'registros',
            'visitantes',
            'totalAcessos',
            'entradasHoje',
            'saidasHoje',
            'acessosBloqueados'
        ));
    }

    public function create(Request $request)
    {
        $visitantes = Visitante::all();
        $apartamentos = Apartamento::all();
        return view("pages.registros.register", compact('visitantes', 'apartamentos'));
    }

    public function store(Request $request)
    {
         $data = $request->validate([
            'id_visitante' => 'nullable|integer',
            'id_apartamento' => 'nullable|integer|exists:apartamentos,id',
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|min:11|max:15',
            'empresa' => 'nullable|string|max:50',
            'veiculo' => 'nullable|string|max:30',
            'placa' => 'nullable|string|max:10',
            'tipo_acesso' => 'required|string|max:40',
            'status' => 'nullable|in:liberado,bloqueado',
            'observacoes' => 'required|string|max:500',
        ]);

        // Recebe o status, padrão 'liberado'
        $status = $request->input('status', 'liberado');
        $data['status'] = $status;

        // Se status for liberado, registra a entrada, caso contrário não registra data de entrada
        if ($status === 'liberado') {
            $data['entrada'] = now();
        } else {
            // status bloqueado, não registra data de entrada nem saída
            $data['entrada'] = null;
            $data['saida'] = null;
        }

        try {
            if ($request->filled('id_visitante')) {
                $visitante = Visitante::find($request->id_visitante);

                if (!$visitante) {
                    return redirect()->back()->with('error', 'Visitante não encontrado.');
                }

                // Opcional: Impede liberar acesso a visitante bloqueado (mas permite registrar tentativa)
                if ($visitante->status === 'bloqueado' && $status === 'liberado') {
                    return redirect()->back()->with('error', 'Este visitante está bloqueado e não pode ter status liberado.');
                }
            }

            $registro = Registro::create($data);

            $this->registrarLog(
                'CREATE',
                'registros',
                $registro->id,
                "Registro de acesso criado para {$data['nome']} com status {$status}."
            );

            return redirect(route('index.registro'))->with('success', 'Entrada registrada com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('ERROR', 'registros', null, "Erro ao criar registro", $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao registrar entrada: ' . $e->getMessage());
        }
    }

    /**
     * Bloqueia edição de registros
     */
    public function edit(string $id)
    {
        return redirect()->route('index.registro')
            ->with('error', 'Edição de registros de acesso não é permitida.');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('index.registro')
            ->with('error', 'Edição de registros de acesso não é permitida.');
    }

    public function destroy(string $id)
    {
        try {
            $registro = Registro::findOrFail($id);
            $nome = $registro->nome;
            $registro->delete();

            $this->registrarLog('DELETE', 'registros', $id, "Registro de {$nome} excluído.");

            return redirect()->route('index.registro')->with('success', 'Registro excluído com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('ERROR', 'registros', $id, "Erro ao excluir registro", $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao excluir registro: ' . $e->getMessage());
        }
    }

    public function getRegisterByVisitante($id)
    {
        $visitante = Visitante::with(['veiculo', 'prestador'])->find($id);

        if (!$visitante) {
            return response()->json(['error' => 'Visitante não encontrado'], 404);
        }

        return response()->json([
            'nome' => $visitante->nome,
            'documento' => $visitante->documento,
            'empresa' => $visitante->prestador->empresa ?? '',
            'modelo' => $visitante->veiculo->modelo ?? '',
            'placa' => $visitante->veiculo->placa ?? '',
            'image' => $visitante->image ?? ''
        ]);
    }

    public function registrarSaida($id)
    {
        try {
            $registro = Registro::findOrFail($id);

            if ($registro->status === 'bloqueado') {
                return redirect()->back()->with('error', 'Não é possível registrar saída de um acesso bloqueado.');
            }

            if ($registro->saida) {
                return redirect()->back()->with('warning', 'A saída já foi registrada anteriormente.');
            }

            $registro->saida = now();
            $registro->save();

            $this->registrarLog(
                'UPDATE',
                'registros',
                $registro->id,
                "Saída registrada para {$registro->nome}."
            );

            return redirect(route('index.registro'))->with('success', 'Saída registrada com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('ERROR', 'registros', $id, "Erro ao registrar saída", $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao registrar saída: ' . $e->getMessage());
        }
    }
}
