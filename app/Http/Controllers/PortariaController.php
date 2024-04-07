<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use App\Models\Morador;
use Illuminate\Http\Request;

class PortariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $morador = Morador::all();
        $apartamentos = Apartamento::all();
        return view('pages.portaria.index', compact('morador', 'apartamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Morador::create($request->validate([
            'nome' => 'string|max:50',
            'foto' => 'integer|max:50',
            'documento' => 'string|max:13',
            'empresa' => 'string|max:12',
            'veiculo' => 'string|max:12',
            'placa' => 'string|max:12',
            'tipo_morador' => 'string|max:40',
            'tipo_acesso' => 'string|max:40',
            'local_descricao' => 'string|max:40',
            'observacao' => 'string|max:500'
        ]));

        return redirect(route('index.morador'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
