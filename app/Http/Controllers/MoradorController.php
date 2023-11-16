<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        return view("pages.moradores.register");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $store = Morador::created([
            'name' => $request->name,
            'cpf' => $request->cpf,
            'data_nasc' => $request->birthdate,
            'telefone' => $request->telefone,
            'email' => $request->email
        ]);

        
        if($store){
            return redirect(route('index.morador'));
        }
        
        dd($request);
        dd("erro");

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
