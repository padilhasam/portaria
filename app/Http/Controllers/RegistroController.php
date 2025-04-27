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
        //$registros = Registro::orderBy('entrada', 'asc')->paginate(10);

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
            'nome' => 'required|string|max:50',
            'documento' => 'required|string|min:11|max:14',
            'empresa' => 'nullable|string|max:50',
            'veiculo' => 'nullable|string|max:30',
            'placa' => 'nullable|string|max:12',
            'tipo_acesso' => 'required|string|max:40',
            'observacoes' => 'required|string|max:500',
            'img' => 'nullable|image|max:2048'
        ]);

    
        if ($request->hasFile('img')) {
            $caminho = $request->file('img')->store('registros', 'public');
            $data['img'] = Storage::url($caminho); // retorna o caminho acessível via URL
        } elseif ($request->has('img') && is_string($request->input('img'))) {
            $file = $request->file('img');
            if ($file && $file->isValid()) {
                $caminho = $file->store('registros', 'public');
                $data['img'] = Storage::url($caminho);
            }
        }
    
        // Define a entrada atual
        $data['entrada'] = now();
    
        $registro = Registro::create($data);
    
        if ($registro) {
            return redirect(route('index.registro'))->with(['success' => true, 'message' => 'Entrada registrada com sucesso!']);
        } else {
            return redirect(route('index.registro'))->with(['success' => false, 'message' => 'Erro ao registrar entrada!']);
        }
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
            'nome' => 'required|string|max:50',
            'documento' => 'required|string|min:11|max:14',
            'empresa' => 'nullable|string|max:50',
            'veiculo' => 'nullable|string|max:30',
            'placa' => 'nullable|string|max:12',
            'tipo_acesso' => 'required|string|max:40',
            'observacoes' => 'required|string|max:500',
            'img' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('img')) {
            $caminho = $request->file('img')->store('registros', 'public');
            $data['img'] = Storage::url($caminho);
        }

        $registro->update($data);

        return redirect()->route('index.registro')->with(['success', 'Registro atualizado com sucesso!', 'message' => 'Atualizado com sucesso!']);
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

        return redirect(route('index.registro'))->with('success', 'Saída registrada com sucesso!');
    }
}