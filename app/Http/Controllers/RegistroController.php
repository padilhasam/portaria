<?php

namespace App\Http\Controllers;

use App\Models\Registro;
use App\Models\Visitante;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Registro::with('visitante')->orderBy('entrada', 'desc');

        // Filtro por data de entrada
        if ($request->filled('entrada_inicio')) {
            $query->whereDate('entrada', '>=', $request->entrada_inicio);
        }

        if ($request->filled('entrada_fim')) {
            $query->whereDate('entrada', '<=', $request->entrada_fim);
        }

        // Filtro por visitante
        if ($request->filled('visitante_id')) {
            $query->where('id_visitante', $request->visitante_id);
        }

        // Filtro por tipo de acesso
        if ($request->filled('tipo')) {
            if ($request->tipo == 'entrada') {
                $query->whereNotNull('entrada')->whereNull('saida');
            } elseif ($request->tipo == 'saida') {
                $query->whereNotNull('saida');
            }
        }

        // Filtro por busca textual (nome, documento, bloco, apartamento...)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                ->orWhere('documento', 'like', "%{$search}%")
                ->orWhere('empresa', 'like', "%{$search}%")
                ->orWhere('placa', 'like', "%{$search}%")
                ->orWhere('veiculo', 'like', "%{$search}%");
            });
        }

        $registros = $query->paginate(10);

        // Totais gerais
        $totalAcessos = Registro::count();
        $entradasHoje = Registro::whereDate('entrada', Carbon::today())->count();
        $saidasHoje = Registro::whereDate('saida', Carbon::today())->count();
        $acessosBloqueados = Registro::where('tipo_acesso', 'bloqueado')->count();

        // Visitantes para o filtro
        $visitantes = Visitante::orderBy('nome')->get();

        return view('pages.registros.index', compact('registros', 'visitantes', 'totalAcessos', 'entradasHoje', 'saidasHoje', 'acessosBloqueados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $visitantes = Visitante::all();
        return view("pages.registros.register", compact('visitantes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_visitante' => 'nullable|integer',
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|min:11|max:15',
            'empresa' => 'nullable|string|max:50',
            'veiculo' => 'nullable|string|max:30',
            'placa' => 'nullable|string|max:10',
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
            return redirect(route('index.registro'))->with('success', 'Entrada registrada com sucesso!');
        } else {
            return redirect(route('index.registro'))->with('error', 'Erro ao registrar entrada!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $registro = Registro::with('visitante.prestador')->findOrFail($id);
        return view('pages.registros.register', compact('registro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $registro = Registro::findOrFail($id);

        $data = $request->validate([
            'id_visitante' => 'nullable|integer',
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|min:11|max:15',
            'empresa' => 'nullable|string|max:50',
            'veiculo' => 'nullable|string|max:30',
            'placa' => 'nullable|string|max:10',
            'tipo_acesso' => 'required|string|max:40',
            'observacoes' => 'required|string|max:500',
            'img' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('img')) {
            $caminho = $request->file('img')->store('registros', 'public');
            $data['img'] = Storage::url($caminho);
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
     * Retorna os detalhes do visitante em formato JSON para uso em formulários.
     */
    public function getRegisterByVisitante($id)
    {
        $visitante = Visitante::with(['veiculo', 'prestador'])->find($id);

        if (!$visitante) {
            return response()->json(['error' => 'Visitante não encontrado'], 404);
        }

        return response()->json([
            'nome' => $visitante->nome,
            'documento' => $visitante->documento,
            'empresa' => $visitante->prestador->empresa ?? '', // Corrigido para vir do relacionamento
            'modelo' => $visitante->veiculo->modelo ?? '',
            'placa' => $visitante->veiculo->placa ?? '',
            'image' => $visitante->image ?? ''
        ]);
    }

        /**
     * Retorna os detalhes do visitante em formato JSON para uso em formulários.
     */
    public function getVeiculoByVisitante($id)
    {
        $visitante = Visitante::select($id);
        return response()->json([
            // 'placa' => $veiculo->placa,
            // 'marca' => $veiculo->marca,
            // 'modelo' => $veiculo->modelo,
            // 'cor' => $veiculo->cor,
        ]);
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
