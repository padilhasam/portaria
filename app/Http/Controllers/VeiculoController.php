<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    /**
     * Exibe a lista de veículos com paginação.
     */
    public function index()
    {
        $veiculos = Veiculo::latest()->paginate(10); // Adicionada paginação
        return view('pages.veiculos.index', compact('veiculos'));
    }

    /**
     * Exibe o formulário para criar um novo veículo.
     */
    public function create()
    {
        return view("pages.veiculos.register");
    }

    /**
     * Armazena um novo veículo no banco de dados.
     */
    public function store(Request $request)
    {
        $validated = $this->validateVeiculo($request); // Usando o método de validação

        $veiculo = Veiculo::create($validated);

        // Verifica se o redirecionamento vem da página do morador
        if ($veiculo) {
            return redirect()->route('index.veiculo')->with([
                'success' => true,
                'message' => 'Veículo registrado com sucesso!'
            ]);
        } else {
            return redirect()->route('index.veiculo')->with([
                'success' => false,
                'message' => 'Erro ao registrar veículo!'
            ]);
        }
    }

    /**
     * Exibe as informações detalhadas de um veículo.
     */
    public function show(string $id)
    {
        $veiculo = Veiculo::findOrFail($id); // Usando findOrFail para garantir que o veículo existe
        return view('pages.veiculos.show', compact('veiculo')); // Crie uma view 'show' se necessário
    }

    /**
     * Exibe o formulário para editar as informações de um veículo.
     */
    public function edit(string $id)
    {
        $veiculo = Veiculo::findOrFail($id);
        return view('pages.veiculos.register', compact('veiculo'));
    }

    /**
     * Atualiza as informações de um veículo existente.
     */
    public function update(Request $request, string $id)
    {
        $veiculo = Veiculo::findOrFail($id);

        $validated = $this->validateVeiculo($request, $veiculo->id); // Usando o método de validação

        $veiculo->update($validated);

        return redirect()->route('index.veiculo')->with('success', 'Veículo atualizado com sucesso!');
    }

    /**
     * Remove um veículo do banco de dados.
     */
    public function destroy(string $id)
    {
        $veiculo = Veiculo::findOrFail($id);
        $veiculo->delete();

        return redirect()->route('index.veiculo')->with('success', 'Veículo removido com sucesso!');
    }

    /**
     * Retorna os detalhes do veículo em formato JSON para uso em formulários.
     */
    public function getDetails($id)
    {
        $veiculo = Veiculo::findOrFail($id);
        return response()->json([
            'placa' => $veiculo->placa,
            'vaga' => $veiculo->vaga,
        ]);
    }

    /**
     * Valida os dados de um veículo.
     */
    private function validateVeiculo(Request $request, $veiculo_id = null)
    {
        return $request->validate([
            'placa' => 'required|string|max:7|unique:veiculos,placa,' . $veiculo_id, // Validando a placa com a exceção para o próprio registro
            'tipo' => 'required|string|max:12',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'cor' => 'required|string|max:15',
            'vaga' => 'nullable|string|max:10', // Se a vaga for opcional
            'observacao' => 'nullable|string|max:255', // Observações com limite maior
        ], [
            'placa.required' => 'A placa do veículo é obrigatória.',
            'placa.unique' => 'A placa informada já está cadastrada.',
            'tipo.required' => 'O tipo de veículo é obrigatório.',
            'marca.required' => 'A marca do veículo é obrigatória.',
            'modelo.required' => 'O modelo do veículo é obrigatório.',
            'cor.required' => 'A cor do veículo é obrigatória.',
            'vaga.max' => 'A vaga pode ter no máximo 10 caracteres.',
            'observacao.max' => 'A observação pode ter no máximo 255 caracteres.',
        ]);
    }
}