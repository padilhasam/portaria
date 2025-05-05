<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use App\Models\Veiculo;
use App\Models\Morador;
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
                             ->orWhere('documento', 'like', "%{$this->unmask($search)}%");
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
            ->orWhere('documento', 'like', "%{$this->unmask($search)}%")
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

        // Conversão da data para formato MySQL
        $validated['nascimento'] = $this->convertDateToMySQL($validated['nascimento']);
        $validated['documento'] = $this->unmask($validated['documento']);

        Morador::create($validated);

        return redirect()->route('index.morador')->with('success', 'Morador cadastrado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $morador = Morador::with(['apartamento', 'veiculo'])->findOrFail($id); // Eager load relationships
        $morador->nascimento = $this->convertDateToBR($morador->nascimento);
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
        $validated['documento'] = $this->unmask($validated['documento']);
        $validated['nascimento'] = $this->convertDateToMySQL($validated['nascimento']);

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
            'nome' => 'required|string|max:100',
            'documento' => 'required|string|max:14|unique:moradores,documento,' . ($request->route('id') ?? ''),
            'nascimento' => 'required|date', // Validando como data
            'tel_fixo' => 'nullable|string|max:14',
            'celular' => 'required|string|max:15',
            'email' => 'nullable|string|email|max:100',
            'tipo_morador' => 'required|string|max:40|in:aluguel,propria',
        ]);
    }

    /**
     * Remove máscaras de strings (e.g., CPF).
     */
    private function unmask($string)
    {
        return preg_replace('/[^0-9]/', '', $string);
    }

    /**
     * Converte data do formato dd/mm/yyyy para yyyy-mm-dd (MySQL).
     */
    private function convertDateToMySQL($date)
    {
        if (!$date) return null;

        $parts = explode('/', $date);
        if (count($parts) === 3) {
            return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }

        return $date; // Se já estiver no formato correto
    }

    /**
     * Converte data do formato yyyy-mm-dd para dd/mm/yyyy.
     */
    private function convertDateToBR($date)
    {
        if (!$date) return null;

        $parts = explode('-', $date);
        if (count($parts) === 3) {
            return $parts[2] . '/' . $parts[1] . '/' . $parts[0];
        }

        return $date;
    }
}