<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Illuminate\Http\Request;
use Exception;
use App\Traits\Loggable; // ✅ Importa o Trait

class VeiculoController extends Controller
{
    use Loggable; // ✅ Usa o Trait para registrar logs

    /**
     * Exibe a lista de veículos com paginação.
     */
    public function index(Request $request)
    {
        $query = Veiculo::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('placa', 'like', "%{$search}%")
                  ->orWhere('marca', 'like', "%{$search}%")
                  ->orWhere('modelo', 'like', "%{$search}%");
            });
        }

        if ($cor = $request->input('cor')) {
            $query->where('cor', 'like', "%{$cor}%");
        }

        if ($tipo = $request->input('tipo')) {
            $query->where('tipo', $tipo);
        }

        $veiculos = $query->latest()->paginate(10)->withQueryString();

        return view('pages.veiculos.index', compact('veiculos'));
    }

    public function create()
    {
        return view("pages.veiculos.register");
    }

    public function store(Request $request)
    {
        $request->merge([
            'tipo_placa' => $request->has('tipo_placa') ? 'mercosul' : 'comum',
        ]);

        $validated = $this->validateVeiculo($request);

        try {
            $veiculo = Veiculo::create($validated);

            $this->registrarLog('CREATE', 'veiculos', $veiculo->id, "Veículo {$veiculo->placa} registrado com sucesso.");

            return redirect()->route('index.veiculo')->with('success', 'Veículo registrado com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('CREATE', 'veiculos', null, 'Erro ao registrar veículo', $e->getMessage());

            return redirect()->route('index.veiculo')->with('error', 'Erro ao registrar veículo!');
        }
    }

    public function show(string $id)
    {
        $veiculo = Veiculo::findOrFail($id);
        return view('pages.veiculos.show', compact('veiculo'));
    }

    public function edit(string $id)
    {
        $veiculo = Veiculo::findOrFail($id);
        return view('pages.veiculos.register', compact('veiculo'));
    }

    public function update(Request $request, string $id)
    {
        $veiculo = Veiculo::findOrFail($id);

        $request->merge([
            'tipo_placa' => $request->has('tipo_placa') ? 'mercosul' : 'comum',
        ]);

        $validated = $this->validateVeiculo($request, $veiculo->id);

        try {
            $veiculo->update($validated);

            $this->registrarLog('UPDATE', 'veiculos', $veiculo->id, "Veículo {$veiculo->placa} atualizado com sucesso.");

            return redirect()->route('index.veiculo')->with('success', 'Veículo atualizado com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('UPDATE', 'veiculos', $veiculo->id, 'Erro ao atualizar veículo', $e->getMessage());

            return redirect()->route('index.veiculo')->with('error', 'Erro ao atualizar veículo!');
        }
    }

    public function destroy(string $id)
    {
        $veiculo = Veiculo::findOrFail($id);

        try {
            $veiculo->delete();

            $this->registrarLog('DELETE', 'veiculos', $id, "Veículo {$veiculo->placa} removido com sucesso.");

            return redirect()->route('index.veiculo')->with('success', 'Veículo removido com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('DELETE', 'veiculos', $id, 'Erro ao remover veículo', $e->getMessage());

            return redirect()->route('index.veiculo')->with('error', 'Erro ao remover veículo!');
        }
    }

    public function getDetails($id)
    {
        $veiculo = Veiculo::findOrFail($id);
        return response()->json([
            'placa' => $veiculo->placa,
            'marca' => $veiculo->marca,
            'modelo' => $veiculo->modelo,
            'cor' => $veiculo->cor,
        ]);
    }

    private function validateVeiculo(Request $request, $veiculo_id = null)
    {
        return $request->validate([
            'placa'        => 'required|string|max:10|unique:veiculos,placa,' . $veiculo_id,
            'tipo'         => 'required|string|max:30',
            'marca'        => 'required|string|max:50',
            'modelo'       => 'required|string|max:50',
            'cor'          => 'required|string|max:20',
            'vaga'         => 'nullable|string|max:20',
            'observacoes'  => 'nullable|string|max:255',
            'tipo_placa'   => 'required|in:comum,mercosul',
        ], [
            'placa.required' => 'A placa do veículo é obrigatória.',
            'placa.unique'   => 'A placa informada já está cadastrada.',
            'tipo.required'  => 'O tipo de veículo é obrigatório.',
            'marca.required' => 'A marca do veículo é obrigatória.',
            'modelo.required'=> 'O modelo do veículo é obrigatório.',
            'cor.required'   => 'A cor do veículo é obrigatória.',
            'vaga.max'       => 'A vaga pode ter no máximo 10 caracteres.',
            'observacoes.max'=> 'A observação pode ter no máximo 255 caracteres.',
        ]);
    }
}
