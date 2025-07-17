<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Apartamento;
use App\Models\Veiculo;
use App\Models\Morador;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\Loggable; // ✅ Importando o Trait
use Exception;

class MoradorController extends Controller
{
    use Loggable; // ✅ Habilita logs

    public function index(Request $request)
    {
        $search = $request->input('search');
        $tipo = $request->input('tipo_morador');

        $moradores = Morador::query()
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nome', 'like', "%{$search}%")
                      ->orWhere('documento', 'like', "%{$search}%")
                      ->orWhereHas('apartamento', function ($q2) use ($search) {
                          $q2->where('bloco', 'like', "%{$search}%")
                             ->orWhere('numero', 'like', "%{$search}%");
                      });
                });
            })
            ->when($tipo, fn($query, $tipo) => $query->where('tipo_morador', $tipo))
            ->with(['apartamento', 'veiculo'])
            ->latest()
            ->paginate(10);

        return view('pages.moradores.index', compact('moradores', 'search', 'tipo'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $moradores = Morador::query()
            ->where('nome', 'like', "%{$search}%")
            ->orWhere('documento', 'like', "%{$search}%")
            ->limit(10)
            ->get(['id', 'nome', 'documento']);

        return response()->json($moradores);
    }

    public function create()
    {
        $apartamentos = Apartamento::orderBy('numero')->get();
        $veiculos = Veiculo::orderBy('placa')->get();
        return view("pages.moradores.register", compact('apartamentos', 'veiculos'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateMorador($request);

        try {
            $morador = Morador::create($validated);

            $this->registrarLog('CREATE', 'moradores', $morador->id, "Morador {$morador->nome} registrado no apartamento ID {$morador->id_apartamento}.");

            return redirect()->route('index.morador')->with('success', 'Morador registrado com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('CREATE', 'moradores', null, 'Erro ao registrar morador.', $e->getMessage());
            return redirect()->route('index.morador')->with('error', 'Erro ao registrar morador!');
        }
    }

    public function edit(string $id)
    {
        $morador = Morador::with(['apartamento', 'veiculo'])->findOrFail($id);
        $apartamentos = Apartamento::orderBy('numero')->get();
        $veiculos = Veiculo::orderBy('placa')->get();

        return view('pages.moradores.register', compact('morador', 'apartamentos', 'veiculos'));
    }

    public function update(Request $request, string $id)
    {
        $morador = Morador::findOrFail($id);
        $validated = $this->validateMorador($request);

        try {
            $morador->update($validated);

            $this->registrarLog('UPDATE', 'moradores', $morador->id, "Morador {$morador->nome} atualizado com sucesso.");

            return redirect()->route('index.morador')->with('success', 'Morador atualizado com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('UPDATE', 'moradores', $morador->id, "Erro ao atualizar morador {$morador->nome}.", $e->getMessage());
            return redirect()->route('index.morador')->with('error', 'Erro ao atualizar morador!');
        }
    }

    public function destroy(string $id)
    {
        $morador = Morador::findOrFail($id);

        try {
            $nome = $morador->nome;
            $morador->delete();

            $this->registrarLog('DELETE', 'moradores', $id, "Morador {$nome} removido com sucesso.");

            return redirect()->route('index.morador')->with('success', 'Morador removido com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('DELETE', 'moradores', $id, "Erro ao remover morador {$morador->nome}.", $e->getMessage());
            return redirect()->route('index.morador')->with('error', 'Erro ao remover morador!');
        }
    }

    private function validateMorador(Request $request)
    {
        return $request->validate([
            'id_apartamento' => 'required|integer|exists:apartamentos,id',
            'id_veiculo' => 'nullable|integer|exists:veiculos,id',
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|min:11|max:14|unique:moradores,documento,' . ($request->route('id') ?? ''),
            'nascimento' => 'required|date',
            'tel_fixo' => 'nullable|string|max:20',
            'celular' => 'required|string|max:20',
            'email' => 'nullable|string|email|max:255',
            'tipo_morador' => 'required|string|max:40|in:aluguel,propria',
        ]);
    }
}
