<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registros = Registro::orderBy('entrada', 'desc')->paginate(10);

        // Totais calculados com base em todos os registros
        $totalAcessos = Registro::count();
        $entradasHoje = Registro::whereDate('entrada', Carbon::today())->count();
        $saidasHoje = Registro::whereDate('saida', Carbon::today())->count();

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
        $data = $request->validate([
            'nome' => 'nullable|string|max:50',
            'documento' => 'nullable|string|max:14',
            'empresa' => 'nullable|string|max:30',
            'veiculo' => 'nullable|string|max:30',
            'placa' => 'nullable|string|max:12',
            'tipo_morador' => 'nullable|string|max:40',
            'observacoes' => 'nullable|string|max:500',
            'img' => 'nullable|image|max:2048'
        ]);
    
        if ($request->hasFile('img')) {
            $caminho = $request->file('img')->store('registros', 'public');
            $data['foto'] = Storage::url($caminho); // retorna o caminho acessível via URL
        }
    
        // Define a entrada atual
        $data['entrada'] = now();
    
        Registro::create($data);
    
        return redirect()->route('index.registro')->with('success', 'Registro criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $registro = Registro::findOrFail($id);
        return view('pages.registros.register', compact('registro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $registro = Registro::findOrFail($id);

        $data = $request->validate([
            'nome' => 'nullable|string|max:50',
            'documento' => 'nullable|string|max:13',
            'empresa' => 'nullable|string|max:30',
            'veiculo' => 'nullable|string|max:30',
            'placa' => 'nullable|string|max:12',
            'tipo_morador' => 'nullable|string|max:40',
            'observacoes' => 'nullable|string|max:500',
            'img' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('img')) {
            $caminho = $request->file('img')->store('registros', 'public');
            $data['foto'] = Storage::url($caminho);
        }

        $registro->update($data);

        return redirect()->route('index.registro')->with('success', 'Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $registro = Registro::findOrFail($id);
        $registro->delete();

        return redirect()->route('index.registro')->with('success', 'Registro excluído com sucesso!');
    }

    /**
     * Marca a saída atual no registro.
     */
    public function registrarSaida($id)
    {
        $registro = Registro::findOrFail($id);

        if (!$registro->saida) {
            $registro->saida = now();
            $registro->save();
        }

        return redirect()->back()->with('success', 'Saída registrada com sucesso!');
    }
}