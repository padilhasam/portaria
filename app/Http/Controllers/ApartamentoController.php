<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use App\Traits\Loggable; // ✅ Importação do Trait
use Exception;

class ApartamentoController extends Controller
{
    use Loggable; // ✅ Usa o Trait para registrar logs

    public function index(Request $request)
    {
        $query = Apartamento::query();

        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                  ->orWhere('bloco', 'like', "%{$search}%")
                  ->orWhere('ramal', 'like', "%{$search}%")
                  ->orWhere('situacao', 'like', "%{$search}%")
                  ->orWhere('vaga', 'like', "%{$search}%")
                  ->orWhere('status_vaga', 'like', "%{$search}%");
            });
        }

        if ($bloco = $request->input('bloco')) {
            $query->where('bloco', $bloco);
        }

        if ($situacao = $request->input('situacao')) {
            $query->where('situacao', $situacao);
        }

        $apartamentos = $query->latest()->paginate(10)->withQueryString();

        return view('pages.apartamentos.index', compact('apartamentos'));
    }

    public function create($veiculo_id = null)
    {
        $apartamentos = Apartamento::all();
        $veiculos = Veiculo::all();
        $selectedVeiculo = $veiculo_id ? Veiculo::find($veiculo_id) : null;

        return view('pages.apartamentos.register', compact('apartamentos', 'veiculos', 'selectedVeiculo'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateApartamento($request);
        $validated['situacao'] = 'vazio';

        try {
            $apartamento = Apartamento::create($validated);

            $this->registrarLog('CREATE', 'apartamentos', $apartamento->id, "Apartamento #{$apartamento->numero} criado com sucesso.");

            return redirect()->route('index.apartamento')->with('success', 'Apartamento registrado com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('CREATE', 'apartamentos', null, 'Erro ao criar apartamento.', $e->getMessage());
            return redirect()->route('index.apartamento')->with('error', 'Erro ao registrar apartamento!');
        }
    }

    public function edit($id)
    {
        $apartamento = Apartamento::findOrFail($id);
        return view('pages.apartamentos.register', compact('apartamento'));
    }

    public function update(Request $request, $id)
    {
        $apartamento = Apartamento::findOrFail($id);
        $validated = $this->validateApartamento($request, $apartamento->id);

        try {
            $apartamento->update($validated);

            $this->registrarLog('UPDATE', 'apartamentos', $apartamento->id, "Apartamento #{$apartamento->numero} atualizado com sucesso.");

            return redirect($request->query('from') ?? route('index.apartamento'))
                ->with('success', "Apartamento #{$apartamento->numero} atualizado com sucesso!");
        } catch (Exception $e) {
            $this->registrarLog('UPDATE', 'apartamentos', $apartamento->id, 'Erro ao atualizar apartamento.', $e->getMessage());
            return redirect()->route('index.apartamento')->with('error', 'Erro ao atualizar apartamento!');
        }
    }

    public function destroy($id)
    {
        $apartamento = Apartamento::findOrFail($id);
        $numero = $apartamento->numero;

        try {
            $apartamento->delete();

            $this->registrarLog('DELETE', 'apartamentos', $id, "Apartamento #{$numero} removido com sucesso.");

            return redirect()->route('index.apartamento')->with('success', "Apartamento #{$numero} removido com sucesso.");
        } catch (Exception $e) {
            $this->registrarLog('DELETE', 'apartamentos', $id, "Erro ao remover apartamento #{$numero}.", $e->getMessage());
            return redirect()->route('index.apartamento')->with('error', 'Erro ao remover apartamento!');
        }
    }

    public function getDetailsApartamento($id)
    {
        $apartamento = Apartamento::findOrFail($id);
        return response()->json([
            'bloco' => $apartamento->bloco,
            'ramal' => $apartamento->ramal,
            'vaga' => $apartamento->vaga
        ]);
    }

    private function validateApartamento(Request $request, $apartamento_id = null)
    {
        return $request->validate([
            'numero' => 'required|string|max:10|unique:apartamentos,numero,' . $apartamento_id,
            'bloco' => 'required|string|max:10',
            'vaga' => 'nullable|string|max:10',
            'ramal' => 'nullable|string|max:10',
            'situacao' => 'nullable|string|max:50|in:ocupado,vazio,alugado,vendido,reforma',
            'status_vaga' => 'required|in:livre,ocupada',
        ]);
    }
}
