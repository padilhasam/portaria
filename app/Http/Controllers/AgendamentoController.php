<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Morador;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    // Listar todos os agendamentos
    public function index()
    {
        $agendamentos = Agendamento::with('morador')->latest()->paginate(10);
        return view('pages.agendamentos.index', compact('agendamentos'));
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
        $request->validate([
            'id_morador' => 'nullable|integer|exists:moradores,id',
            'nome_area' => 'required|string|max:255',
            'data_agendamento' => 'required|date',
            'horario_inicio' => 'required',
            'horario_fim' => 'required|after:horario_inicio',
            'observacoes' => 'nullable|string|max:255',
        ]);
        
        // Verificar conflito
        $conflito = Agendamento::where('nome_area', $request->nome_area)
            ->where('data_agendamento', $request->data_agendamento)
            ->where(function ($query) use ($request) {
                $query->whereBetween('horario_inicio', [$request->horario_inicio, $request->horario_fim])
                    ->orWhereBetween('horario_fim', [$request->horario_inicio, $request->horario_fim])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('horario_inicio', '<=', $request->horario_inicio)
                                ->where('horario_fim', '>=', $request->horario_fim);
                    });
            })
            ->exists();

        if ($conflito) {
            return back()->withErrors(['Conflito de agendamento: já existe um agendamento para essa área nesse horário.'])->withInput();
        }

        // Sem conflito: criar agendamento
        Agendamento::create([
            'id_usuario' => auth()->id(),
            'id_morador' => $request->id_morador,
            'nome_area' => $request->nome_area,
            'data_agendamento' => $request->data_agendamento,
            'horario_inicio' => $request->horario_inicio,
            'horario_fim' => $request->horario_fim,
            'observacoes' => $request->observacoes ?? '',
        ]);
        
        return redirect()->route('index.agendamento')->with('success', 'Agendamento realizado com sucesso.');
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