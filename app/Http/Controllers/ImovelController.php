<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ImovelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $imovel = Imovel::all();
        dd($imovel);
        return view("pages.imovel.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.imovel.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Imovel::create($request->validate([
            'bloco' => 'string|max:2',
            'numero' => 'string|max:4'
        ]));

        return redirect(route('create.imovel'));
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
