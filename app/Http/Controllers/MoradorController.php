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
    public function index()
    {
        $moradores = Morador::all();
        return view('pages.moradores.index', compact('moradores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $apartamentos = Apartamento::all();
        $veiculos = Veiculo::all(); 
        return view("pages.moradores.register", compact('apartamentos', 'veiculos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateMorador($request);
        Morador::create($validated);
        return redirect(route('index.morador'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $morador = Morador::findOrFail($id); // Garantindo que o morador existe
        $apartamentos = Apartamento::all();
        $veiculos = Veiculo::all();

        return view('pages.moradores.register', compact('morador', 'apartamentos', 'veiculos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $morador = Morador::findOrFail($id); // Garantindo que o morador existe
        $validated = $this->validateMorador($request);

        $morador->update($validated);
        return redirect(route('index.morador'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $morador = Morador::findOrFail($id);
        $morador->delete();

        return redirect(route('index.morador'));
    }

    /**
     * Valida os dados do morador.
     */
    private function validateMorador(Request $request)
    {
        return $request->validate([
            'id_apartamento' => 'required|integer|max:10',
            'id_veiculo' => 'nullable|integer',
            'nome' => 'required|string|max:100',
            'documento' => 'required|string|max:14',
            'nascimento' => 'required|string|max:10',
            'tel_fixo' => 'required|string|max:14',
            'celular' => 'required|string|max:15',
            'email' => 'required|string|email|max:100',
            'tipo_morador' => 'required|string|max:40',
        ]);
    }
}