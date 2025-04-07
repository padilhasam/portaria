<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Registro;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $registros = Registro::all();

        $totalAcessos = $registros->count();
        $entradasHoje = $registros->whereNotNull('entrada')->count();
        $saidasHoje = $registros->whereNotNull('saida')->count();

        return view('pages.registros.index', compact('registros', 'totalAcessos', 'entradasHoje', 'saidasHoje'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view("pages.registros.register");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Registro::create($request->validate([
            'nome' => 'string|max:50',
            'documento' => 'string|max:13',
            'empresa' => 'string|max:12',
            'veiculo' => 'string|max:12',
            'placa' => 'string|max:12',
            'foto' => 'integer|max:50',
            'tipo_acesso' => 'string|max:40',
            'local_descricao' => 'string|max:40',
            'observacao' => 'string|max:500'
        ]));

        return redirect(route('index.registro'));
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
