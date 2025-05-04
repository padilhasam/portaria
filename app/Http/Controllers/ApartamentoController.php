<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use Illuminate\Http\Request;

class ApartamentoController extends Controller
{
    public function index()
    {
        $apartamentos = Apartamento::latest()->paginate(10); // Paginação opcional
        return view('pages.apartamentos.index', compact('apartamentos'));
    }

    public function create()
    {
        return view('pages.apartamentos.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:10',
            'bloco' => 'required|string|max:10',
            'vaga' => 'required|string|max:10',
            'ramal' => 'required|string|max:10',
            'situacao' => 'required|string|max:20',
            'status_vaga' => 'required|in:livre,ocupada',
        ]);

        $validated['situacao'] = 'ativo';

        $apartamento = Apartamento::create($validated);

        return redirect($request->query('from') ?? route('index.apartamento'))
            ->with('success', "Apartamento #{$apartamento->numero} cadastrado com sucesso!");
    }

    public function edit($id)
    {
        $apartamento = Apartamento::findOrFail($id);
        return view('pages.apartamentos.register', compact('apartamento'));
    }

    public function update(Request $request, $id)
    {
        $apartamento = Apartamento::findOrFail($id);

        $validated = $request->validate([
            'numero' => 'required|string|max:10',
            'bloco' => 'required|string|max:10',
            'vaga' => 'required|string|max:10',
            'ramal' => 'required|string|max:10',
            'ramal' => 'required|string|max:20',
            'status_vaga' => 'required|in:livre,ocupada',
        ]);

        $apartamento->update($validated);

        return redirect($request->query('from') ?? route('index.apartamento'))
            ->with('success', "Apartamento #{$apartamento->numero} atualizado com sucesso!");
    }

    public function destroy($id)
    {
        $apartamento = Apartamento::findOrFail($id);
        $numero = $apartamento->numero;
        $apartamento->delete();

        return redirect()->back()->with('success', "Apartamento #{$numero} removido com sucesso.");
    }
}