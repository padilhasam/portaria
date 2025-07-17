<?php

namespace App\Http\Controllers;

use App\Models\Prestador;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\CpfValido;
use App\Traits\Loggable; // ✅ Trait de logs
use Exception;

class PrestadorController extends Controller
{
    use Loggable;

    public function index(Request $request)
    {
        $search = $request->input('search');
        $empresa = $request->input('empresa');
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        $empresas = Prestador::select('empresa')
            ->distinct()
            ->orderBy('empresa')
            ->pluck('empresa');

        $prestadores = Prestador::with('veiculo')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('empresa', 'like', "%{$search}%")
                        ->orWhere('documento', 'like', "%{$search}%")
                        ->orWhere('cnpj', 'like', "%{$search}%")
                        ->orWhere('prestador', 'like', "%{$search}%");
                });
            })
            ->when($empresa, fn($q) => $q->where('empresa', $empresa))
            ->when($dataInicio, fn($q) => $q->whereDate('created_at', '>=', $dataInicio))
            ->when($dataFim, fn($q) => $q->whereDate('created_at', '<=', $dataFim))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.prestadores.index', compact('prestadores', 'empresas'));
    }

    public function create()
    {
        $veiculos = Veiculo::all();
        return view('pages.prestadores.register', compact('veiculos'));
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        try {
            $prestador = Prestador::create($request->all());

            $this->registrarLog(
                'CREATE',
                'prestadores',
                $prestador->id,
                "Prestador '{$prestador->prestador}' (empresa: {$prestador->empresa}) cadastrado com sucesso."
            );

            return redirect()->route('index.prestador')->with('success', 'Prestador cadastrado com sucesso.');
        } catch (Exception $e) {
            $this->registrarLog('CREATE', 'prestadores', null, 'Erro ao cadastrar prestador', $e->getMessage());
            return back()->with('error', 'Erro ao cadastrar prestador.');
        }
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

        try {
            $prestador->update($request->all());

            $this->registrarLog(
                'UPDATE',
                'prestadores',
                $prestador->id,
                "Prestador '{$prestador->prestador}' (empresa: {$prestador->empresa}) atualizado com sucesso."
            );

            return redirect()->route('index.prestador')->with('success', 'Prestador atualizado com sucesso.');
        } catch (Exception $e) {
            $this->registrarLog('UPDATE', 'prestadores', $id, 'Erro ao atualizar prestador', $e->getMessage());
            return back()->with('error', 'Erro ao atualizar prestador.');
        }
    }

    public function destroy($id)
    {
        $prestador = Prestador::findOrFail($id);

        try {
            $nome = $prestador->prestador;
            $empresa = $prestador->empresa;
            $prestador->delete();

            $this->registrarLog(
                'DELETE',
                'prestadores',
                $id,
                "Prestador '{$nome}' (empresa: {$empresa}) removido com sucesso."
            );

            return redirect()->route('index.prestador')->with('success', 'Prestador removido com sucesso.');
        } catch (Exception $e) {
            $this->registrarLog('DELETE', 'prestadores', $id, 'Erro ao remover prestador', $e->getMessage());
            return back()->with('error', 'Erro ao remover prestador.');
        }
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'empresa' => 'required|string|max:255',
            'cnpj' => [
                'required',
                'string',
                'max:18',
                Rule::unique('prestadores', 'cnpj')->ignore($request->route('id')),
            ],
            'tel_fixo' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'prestador' => 'required|string|max:255',
            'documento' => [
                'required',
                'string',
                'max:14',
                Rule::unique('prestadores', 'documento')->ignore($request->route('id')),
                new CpfValido,
            ],
            'celular' => 'required|string|max:20',
            'acompanhante' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'id_veiculo' => 'nullable|exists:veiculos,id',
        ]);
    }
}
