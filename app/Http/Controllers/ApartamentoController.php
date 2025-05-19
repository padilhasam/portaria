<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class ApartamentoController extends Controller
{
    /**
     * Exibe a lista de apartamentos com paginação.
     */
    public function index()
    {
        $apartamentos = Apartamento::latest()->paginate(10);
        return view('pages.apartamentos.index', compact('apartamentos'));
    }

    /**
     * Exibe o formulário para criar um novo apartamento.
     */
    public function create($veiculo_id = null)
    {
        $apartamentos = Apartamento::all();
        $veiculos = Veiculo::all();
        $selectedVeiculo = null;

        if ($veiculo_id) {
            $selectedVeiculo = Veiculo::find($veiculo_id);
        }

        return view('pages.apartamentos.register', compact('apartamentos', 'veiculos', 'selectedVeiculo'));
    }

    /**
     * Armazena um novo apartamento no banco de dados.
     */
    public function store(Request $request)
    {
        $validated = $this->validateApartamento($request);
        $validated['situacao'] = 'ativo'; // Define 'ativo' por padrão na criação

        $apartamento = Apartamento::create($validated);

        return redirect($request->query('from') ?? route('index.apartamento'))
            ->with('success', "Apartamento #{$apartamento->numero} cadastrado com sucesso!");
    }

    /**
     * Exibe o formulário para editar um apartamento existente.
     */
    public function edit($id)
    {
        $apartamento = Apartamento::findOrFail($id);
        return view('pages.apartamentos.register', compact('apartamento'));
    }

    /**
     * Atualiza as informações de um apartamento existente.
     */
    public function update(Request $request, $id)
    {
        $apartamento = Apartamento::findOrFail($id);
        $validated = $this->validateApartamento($request, $apartamento->id);

        $apartamento->update($validated);

        return redirect($request->query('from') ?? route('index.apartamento'))
            ->with('success', "Apartamento #{$apartamento->numero} atualizado com sucesso!");
    }

    /**
     * Remove um apartamento do banco de dados.
     */
    public function destroy($id)
    {
        $apartamento = Apartamento::findOrFail($id);
        $numero = $apartamento->numero;
        $apartamento->delete();

        return redirect()->route('index.apartamento')->with('success', "Apartamento #{$numero} removido com sucesso.");
    }

    /**
     * Retorna os detalhes de um apartamento em formato JSON (usado para preenchimento automático).
     */
    public function getDetails($id)
    {
        $apartamento = Apartamento::findOrFail($id);
        return response()->json([
            'bloco' => $apartamento->bloco,
            'ramal' => $apartamento->ramal,
        ]);
    }

    /**
     * Valida os dados de um apartamento.
     */
    private function validateApartamento(Request $request, $apartamento_id = null)
    {
        return $request->validate([
            'numero' => 'required|string|max:10|unique:apartamentos,numero,' . $apartamento_id,
            'bloco' => 'required|string|max:10',
            'vaga' => 'nullable|string|max:10',
            'ramal' => 'nullable|string|max:10',
            'situacao' => 'nullable|string|max:50|in:ativo,inativo',
            'status_vaga' => 'required|in:livre,ocupada',
        ]);
    }
}