<?php

namespace App\Http\Controllers;
use App\Models\Correspondencia;
use App\Models\Morador;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CorrespondenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $moradores = Morador::orderBy('nome')->get();

        $query = Correspondencia::with('morador')->orderBy('recebida_em', 'desc');

        if ($request->filled('id_morador')) {
            $query->where('id_morador', $request->id_morador);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('inicio')) {
            $query->whereDate('recebida_em', '>=', $request->inicio);
        }

        if ($request->filled('fim')) {
            $query->whereDate('recebida_em', '<=', $request->fim);
        }

        $correspondencias = $query->paginate(10)->withQueryString();

        return view('pages.correspondencias.index', compact('correspondencias', 'moradores'));
    }

    public function create()
    {
        $moradores = Morador::orderBy('nome')->get();
        return view('pages.correspondencias.register', compact('moradores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_morador' => 'required|exists:moradores,id',
            'tipo' => 'required|string',
            'remetente' => 'nullable|string',
            'observacoes' => 'nullable|string',
        ]);

        Correspondencia::create($request->all());

        return redirect()->route('index.correspondencia')->with('success', 'Correspondência registrada com sucesso!');
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

    public function entregar($id)
    {
        $correspondencia = Correspondencia::findOrFail($id);
        $correspondencia->status = 'Entregue';
        $correspondencia->entregue_em = Carbon::now();
        $correspondencia->save();

        return redirect()->route('index.correspondencia')->with('success', 'Correspondência entregue com sucesso!');
    }
}
