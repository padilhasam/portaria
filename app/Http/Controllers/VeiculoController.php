<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $veiculos = Veiculo::all();
        return view('pages.veiculos.index', compact('veiculos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.veiculos.register");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $veiculo = Veiculo::create($request->validate([
            'placa' => 'string|max:7',
            'tipo' => 'string|max:7',
            'marca' => 'string|max:50',
            'modelo' => 'string|max:50',
            'cor' => 'string|max:15',
            'observacao' => 'string|max:10'
        ]));
    
        if ($request->query('from') === 'morador') {
            return redirect()->route('create.morador', ['veiculo_id' => $veiculo->id])
                            ->with('success', 'Veículo cadastrado com sucesso!');
        }
    
        return redirect()->route('index.veiculo')
                         ->with('success', 'Veículo cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Veiculo::where('id', $id)
        ->update($request->validate([
            'placa' => 'string|max:7',
            'tipo' => 'string|max:7',
            'marca' => 'string|max:10',
            'modelo' => 'string|max:10',
            'cor' => 'string|max:10',
            'observacao' => 'string|max:10'
        ]));

        return redirect(route('index.veiculo'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
