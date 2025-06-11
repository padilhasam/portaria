<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Morador;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    // Listar agendamentos e exibir a view do calendário
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Agendamento::with('morador')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('morador', fn ($q2) => $q2->where('nome', 'like', "%{$search}%"))
                  ->orWhere('nome_area', 'like', "%{$search}%");
            });
        }

        $agendamentos = $query->paginate(10);
        $eventos = $this->formatarEventos($query->get());

        return view('pages.agendamentos.index', compact('agendamentos', 'eventos'));
    }

    // API: Retornar apenas eventos em formato JSON (para o FullCalendar via AJAX)
    public function eventos()
    {
        $agendamentos = Agendamento::with('morador')->latest()->get();
        return response()->json($this->formatarEventos($agendamentos));
    }

    // Mostrar formulário de criação
    public function create()
    {
        $moradores = Morador::all();
        return view('pages.agendamentos.register', compact('moradores'));
    }

    // Salvar novo agendamento
    public function store(Request $request)
    {
        $validated = $this->validarDados($request);

        if ($this->existeConflito(null, $validated)) {
            return back()->withErrors(['Conflito de agendamento: já existe um agendamento para essa área nesse horário.'])->withInput();
        }

        Agendamento::create([
            'id_usuario' => auth()->id(),
            'id_morador' => $validated['id_morador'] ?? null,
            'nome_area' => $validated['nome_area'],
            'data_agendamento' => $validated['data_agendamento'],
            'horario_inicio' => $validated['horario_inicio'],
            'horario_fim' => $validated['horario_fim'],
            'observacoes' => $validated['observacoes'] ?? '',
        ]);

        return redirect()->route('index.agendamento')->with([
            'success' => true,
            'message' => 'Agendamento realizado com sucesso!'
        ]);
    }

    // Mostrar formulário de edição
    public function edit($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $moradores = Morador::all();
        return view('pages.agendamentos.register', compact('agendamento', 'moradores'));
    }

    // Atualizar agendamento
    public function update(Request $request, $id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $validated = $this->validarDados($request);

        if ($this->existeConflito($id, $validated)) {
            return back()->withErrors(['Conflito de agendamento: já existe um agendamento para essa área nesse horário.'])->withInput();
        }

        $agendamento->update($validated);

        return redirect()->route('index.agendamento')->with('success', 'Agendamento atualizado com sucesso!');
    }

    // Deletar agendamento
    public function destroy($id)
    {
        Agendamento::findOrFail($id)->delete();
        return redirect()->route('index.agendamento')->with('success', 'Agendamento removido com sucesso!');
    }

    // ---------- MÉTODOS PRIVADOS ----------

    // Validação reutilizável
    private function validarDados(Request $request): array
    {
        return $request->validate([
            'id_morador' => 'nullable|integer|exists:moradores,id',
            'nome_area' => 'required|string|max:255',
            'data_agendamento' => 'required|date',
            'horario_inicio' => 'required',
            'horario_fim' => 'required|after:horario_inicio',
            'observacoes' => 'nullable|string|max:500',
        ]);
    }

    // Verificar conflito de horário
    private function existeConflito($idAtual, array $dados): bool
    {
        return Agendamento::where('nome_area', $dados['nome_area'])
            ->where('data_agendamento', $dados['data_agendamento'])
            ->when($idAtual, fn ($query) => $query->where('id', '!=', $idAtual))
            ->where(function ($query) use ($dados) {
                $query->whereBetween('horario_inicio', [$dados['horario_inicio'], $dados['horario_fim']])
                    ->orWhereBetween('horario_fim', [$dados['horario_inicio'], $dados['horario_fim']])
                    ->orWhere(function ($q) use ($dados) {
                        $q->where('horario_inicio', '<=', $dados['horario_inicio'])
                          ->where('horario_fim', '>=', $dados['horario_fim']);
                    });
            })
            ->exists();
    }

    // Formatador de eventos para o FullCalendar
    private function formatarEventos($agendamentos)
    {
        return $agendamentos->map(function ($agendamento) {
            $cor = match ($agendamento->nome_area) {
                'Sala de Jogos' => '#0d6efd',
                'Churrasqueira' => '#198754',
                'Piscina' => '#0dcaf0',
                'Academia' => '#ffc107',
                'Quadra' => '#3c0386',
                'Biblioteca' => '#dd4e0c',
                default => '#6c757d',
            };

            return [
                'id' => $agendamento->id,
                'title' => ($agendamento->morador->nome ?? 'Morador não informado') . ' - ' . $agendamento->nome_area,
                'start' => $agendamento->data_agendamento . 'T' . substr($agendamento->horario_inicio, 0, 5),
                'end' => $agendamento->data_agendamento . 'T' . substr($agendamento->horario_fim, 0, 5),
                'url' => route('edit.agendamento', $agendamento->id),
                'color' => $cor,
                'allDay' => false,
                'extendedProps' => [
                    'morador' => $agendamento->morador->nome ?? 'Não informado',
                    'area' => $agendamento->nome_area,
                    'observacoes' => $agendamento->observacoes,
                    'horario_inicio' => $agendamento->horario_inicio,
                    'horario_fim' => $agendamento->horario_fim,
                ],
            ];
        });
    }
}