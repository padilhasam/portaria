<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    // Listar todos os agendamentos
    public function index()
    {
        $agendamentos = Agendamento::latest()->paginate(10);
        return view('pages.agendamentos.index', compact('agendamentos'));
    }

    // Mostrar formulário de criação
    public function create()
    {
        return view('pages.agendamentos.register');
    }

    // Salvar novo agendamento
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_area' => 'required|string|max:255',
            'data_agendamento' => 'required|date|after:today',
            'horario_inicio' => 'required',
            'horario_fim' => 'required|after:horario_inicio',
            'observacoes' => 'nullable|string|max:500',
        ]);

        Agendamento::create($validated);

        return redirect()->route('index.agendamento')
            ->with('success', 'Agendamento criado com sucesso!');
    }

    // Mostrar formulário de edição
    public function edit($id)
    {
        $agendamento = Agendamento::findOrFail($id);
        return view('pages.agendamentos.register', compact('agendamento'));
    }

    // Atualizar agendamento
    public function update(Request $request, $id)
    {
        $agendamento = Agendamento::findOrFail($id);

        $validated = $request->validate([
            'nome_area' => 'required|string|max:255',
            'data_agendamento' => 'required|date|after:today',
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