<?php

namespace App\Http\Controllers;

use App\Models\Prestador;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class PrestadorController extends Controller
{
    public function index()
    {
        $prestadores = Prestador::with('veiculo')->orderBy('created_at', 'desc')->paginate(10);
        return view('pages.prestadores.index', compact('prestadores'));
    }

    public function create()
    {
        $veiculos = Veiculo::all();
        return view('pages.prestadores.register', compact('veiculos'));
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        Prestador::create($request->all());

        return redirect()->route('index.prestador')->with('success', 'Prestador cadastrado com sucesso.');
    }

    public function edit($id)
    {
        $prestador = Prestador::findOrFail($id);
        $veiculos = Veiculo::all();

        return view('pages.prestadores.register', compact('prestador', 'veiculos'));
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request);

        $prestador = Prestador::findOrFail($id);
        $prestador->update($request->all());

        return redirect()->route('index.prestador')->with('success', 'Prestador atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $prestador = Prestador::findOrFail($id);
        $prestador->delete();

        return redirect()->route('index.prestador')->with('success', 'Prestador removido com sucesso.');
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'empresa' => 'required|string|max:255',
            'cnpj' => 'required|string|max:18',
            'tel_fixo' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'prestador' => 'required|string|max:255',
            'documento' => 'required|string|max:14',
            'celular' => 'required|string|max:20',
            'acompanhante' => 'required|string|max:255',
            'observacoes' => 'nullable|string',
            'id_veiculo' => 'nullable|exists:veiculos,id',
        ]);
    }
}