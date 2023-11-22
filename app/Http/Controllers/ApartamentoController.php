<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use Illuminate\Http\Request;

class ApartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartamentos = Apartamento::all();
        return view("pages.apartamentos.index", compact('apartamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.apartamentos.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Apartamento::create($request->validate([
            'numero' => 'string|max:4',
            'bloco' => 'string|max:4',
            'ramal' => 'string|max:5',
            'vaga' => 'string|max:10',
            'status_vaga' => 'string|max:10'
        ]));

        return redirect(route('index.apartamento'));
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
        $apartamento = Apartamento::findOrFail($id);
        return view('pages.apartamentos.register', compact('apartamento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Apartamento::where('id', $id)
        ->update($request->validate([
            'bloco' => 'string|max:4',
            'numero' => 'string|max:4',
            'vaga' => 'string|max:10',
            'status_vaga' => 'string|max:10'
        ]));

        return redirect(route('index.apartamento'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
