<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Morador;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    // Listar todos os agendamentos com filtro e eventos para FullCalendar
    public function index(Request $request)
    {
        $query = Agendamento::with('morador')->latest();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('morador', function ($q2) use ($search) {
                    $q2->where('nome', 'like', "%{$search}%");
                })->orWhere('nome_area', 'like', "%{$search}%");
            });
        }

        // Paginação para a tabela
        $agendamentos = $query->paginate(10);

        // Buscar todos para o calendário (sem paginação)
        $todosAgendamentos = $query->get();

       $eventos = $todosAgendamentos->map(function ($agendamento) {
        // Exemplo de lógica simples baseada na área comum
        $cor = match ($agendamento->nome_area) {
            'Salão de Festas' => '#0d6efd',      // Azul
            'Churrasqueira' => '#198754',        // Verde
            'Piscina' => '#0dcaf0',              // Ciano
            'Academia' => '#ffc107',             // Amarelo
            default => '#6c757d',                // Cinza
        };

        return [
            'id' => $agendamento->id,
            'title' => ($agendamento->morador ? $agendamento->morador->nome : 'Morador não informado')
                        . ' - ' . $agendamento->nome_area,
            'start' => $agendamento->data_agendamento . 'T' . substr($agendamento->horario_inicio, 0, 5),
            'end' => $agendamento->data_agendamento . 'T' . substr($agendamento->horario_fim, 0, 5),
            'url' => route('edit.agendamento', $agendamento->id),
            'allDay' => false,
            'color' => $cor,
        ];
    });

        return view('pages.agendamentos.index', compact('agendamentos', 'eventos'));
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
        $validated = $request->validate([
            'id_morador' => 'nullable|integer|exists:moradores,id',
            'nome_area' => 'required|string|max:255',
            'data_agendamento' => 'required|date',
            'horario_inicio' => 'required',
            'horario_fim' => 'required|after:horario_inicio',
            'observacoes' => 'nullable|string|max:255',
        ]);

        // Verificar conflito
        $conflito = Agendamento::where('nome_area', $validated['nome_area'])
            ->where('data_agendamento', $validated['data_agendamento'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('horario_inicio', [$validated['horario_inicio'], $validated['horario_fim']])
                    ->orWhereBetween('horario_fim', [$validated['horario_inicio'], $validated['horario_fim']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('horario_inicio', '<=', $validated['horario_inicio'])
                              ->where('horario_fim', '>=', $validated['horario_fim']);
                    });
            })
            ->exists();

        if ($conflito) {
            return back()
                ->withErrors(['Conflito de agendamento: já existe um agendamento para essa área nesse horário.'])
                ->withInput();
        }

        $agenda = Agendamento::create([
            'id_usuario' => auth()->id(),
            'id_morador' => $validated['id_morador'] ?? null,
            'nome_area' => $validated['nome_area'],
            'data_agendamento' => $validated['data_agendamento'],
            'horario_inicio' => $validated['horario_inicio'],
            'horario_fim' => $validated['horario_fim'],
            'observacoes' => $validated['observacoes'] ?? '',
        ]);

        if ($agenda) {
            return redirect()->route('index.agendamento')->with([
                'success' => true,
                'message' => 'Agendamento realizado com sucesso!'
            ]);
        }

        return redirect()->route('index.agendamento')->with([
            'success' => false,
            'message' => 'Erro ao realizar agendamento!'
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

        $validated = $request->validate([
            'id_morador' => 'nullable|integer|exists:moradores,id',
            'nome_area' => 'required|string|max:255',
            'data_agendamento' => 'required|date',
            'horario_inicio' => 'required',
            'horario_fim' => 'required|after:horario_inicio',
            'observacoes' => 'nullable|string|max:500',
        ]);

        // Verificar conflito ignorando o próprio agendamento atual
        $conflito = Agendamento::where('nome_area', $validated['nome_area'])
            ->where('data_agendamento', $validated['data_agendamento'])
            ->where('id', '!=', $id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('horario_inicio', [$validated['horario_inicio'], $validated['horario_fim']])
                    ->orWhereBetween('horario_fim', [$validated['horario_inicio'], $validated['horario_fim']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('horario_inicio', '<=', $validated['horario_inicio'])
                              ->where('horario_fim', '>=', $validated['horario_fim']);
                    });
            })
            ->exists();

        if ($conflito) {
            return back()
                ->withErrors(['Conflito de agendamento: já existe um agendamento para essa área nesse horário.'])
                ->withInput();
        }

        $agendamento->update($validated);

        return redirect()->route('index.agendamento')
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    // Deletar agendamento
    public function destroy($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        $agendamento->delete();

        return redirect()->route('index.agendamento')
            ->with('success', 'Agendamento removido com sucesso!');
    }
}