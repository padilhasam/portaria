<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use App\Models\Morador;
use Illuminate\Http\Request;

class PortariaRegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $morador = Morador::all();
        $apartamentos = Apartamento::all();
        return view('pages.portariaregistro.index', compact('morador', 'apartamentos'));
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
            'id_apartamento' => 'integer|max:10',
            'nome' => 'string|max:10',
            'documento' => 'string|max:12',
            'birthdate' => 'string|max:12',
            'tel_fixo' => 'string|max:12',
            'celular' => 'string|max:12',
            'email' => 'string|max:40',
            'tipo_morador' => 'string|max:40',
            'image' => 'string|max:500'
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
