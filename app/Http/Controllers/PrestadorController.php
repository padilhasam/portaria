<?php

namespace App\Http\Controllers;

use App\Models\Prestador;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\CpfValido;

class PrestadorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    $empresa = $request->input('empresa');
    $dataInicio = $request->input('data_inicio');
    $dataFim = $request->input('data_fim');

    // Buscar empresas distintas para popular o select
    $empresas = Prestador::select('empresa')
                ->distinct()
                ->orderBy('empresa')
                ->pluck('empresa');

    // Montar query principal com filtros
    $prestadores = Prestador::with('veiculo')
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('empresa', 'like', "%{$search}%")
                  ->orWhere('documento', 'like', "%{$search}%")
                  ->orWhere('cnpj', 'like', "%{$search}%")
                  ->orWhere('prestador', 'like', "%{$search}%");
            });
        })
        ->when($empresa, function ($query, $empresa) {
            $query->where('empresa', $empresa);
        })
        ->when($dataInicio, function ($query, $dataInicio) {
            $query->whereDate('created_at', '>=', $dataInicio);
        })
        ->when($dataFim, function ($query, $dataFim) {
            $query->whereDate('created_at', '<=', $dataFim);
        })
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
            'cnpj' => 'required|string|max:18|unique:prestadores,cnpj' . ($request->method() === 'PUT' ? ',' . $request->route('id') : ''),
            'tel_fixo' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'prestador' => 'required|string|max:255',
            'documento' => ['required','string','max:14', Rule::unique('prestadores', 'documento')->ignore($request->route('id')), new CpfValido,],
            'celular' => 'required|string|max:20',
            'acompanhante' => 'required|string|max:255',
            'observacoes' => 'nullable|string',
            'id_veiculo' => 'nullable|exists:veiculos,id',
        ]);
    }
}
