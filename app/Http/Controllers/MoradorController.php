<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Apartamento;
use App\Models\Veiculo;
use App\Models\Morador;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MoradorController extends Controller
{

    

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $moradores = Morador::query()
            ->when($search, function ($query, $search) {
                return $query->where('nome', 'like', "%{$search}%")
                             ->orWhere('documento', 'like', "%{$search}%");
            })
            ->with(['apartamento', 'veiculo']) // Eager load relationships
            ->latest()
            ->paginate(10); // Paginação de resultados

        return view('pages.moradores.index', compact('moradores', 'search'));
    }

    /**
     * Método para busca de moradores para preenchimento automático.
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        $moradores = Morador::query()
            ->where('nome', 'like', "%{$search}%")
            ->orWhere('documento', 'like', "%{$search}%")
            ->limit(10) // Limita os resultados a 10
            ->get(['id', 'nome', 'documento']); // Selecionando apenas o necessário

        return response()->json($moradores);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $apartamentos = Apartamento::orderBy('numero')->get();
        $veiculos = Veiculo::orderBy('placa')->get();
        return view("pages.moradores.register", compact('apartamentos', 'veiculos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateMorador($request);
        $morador = Morador::create($validated);

        if ($morador) {
            return redirect()->route('index.morador')->with('success', 'Morador registrado com sucesso!');
        } else {
            return redirect()->route('index.morador')->with('error', 'Erro ao registrar Morador!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $morador = Morador::with(['apartamento', 'veiculo'])->findOrFail($id); // Eager load relationships
        
        $apartamentos = Apartamento::orderBy('numero')->get();
        $veiculos = Veiculo::orderBy('placa')->get();

        return view('pages.moradores.register', compact('morador', 'apartamentos', 'veiculos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $morador = Morador::findOrFail($id);
        $validated = $this->validateMorador($request);

        $morador->update($validated);

        return redirect()->route('index.morador')->with('success', 'Morador atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $morador = Morador::findOrFail($id);
        $morador->delete();

        return redirect()->route('index.morador')->with('success', 'Morador removido com sucesso!');
    }

    /**
     * Valida os dados do morador.
     */
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