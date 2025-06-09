<?php

namespace App\Http\Controllers;

use App\Models\Visitante;
use App\Models\Veiculo;
use App\Models\Prestador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisitanteController extends Controller
{
    /**
     * Exibe a listagem de visitantes.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $visitantes = Visitante::query()
            ->when($search, function ($query, $search) {
                return $query->where('nome', 'like', "%{$search}%")
                             ->orWhere('documento', 'like', "%{$this->unmask($search)}%");
            })
            ->with(['veiculo', 'prestador']) // Eager load relationships
            ->latest()
            ->paginate(10); // Paginação de resultados

        /* $visitantes = Visitante::orderBy('created_at', 'desc')->paginate(10); */

        return view('pages.visitantes.index', compact('visitantes','search'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $visitantes = Visitante::query()
            ->where('nome', 'like', "%{$search}%")
            ->orWhere('documento', 'like', "%{$this->unmask($search)}%")
            ->limit(10) // Limita os resultados a 10
            ->get(['id', 'nome', 'documento']); // Selecionando apenas o necessário

        return response()->json($visitantes);
    }

    /**
     * Mostra o formulário de cadastro de visitante.
     */
    public function create()
    {
        $veiculos = Veiculo::orderBy('placa')->get();
        $prestadores = Prestador::orderBy('empresa')->get();
        return view('pages.visitantes.register', compact('veiculos','prestadores'));
    }

    /**
     * Salva um novo visitante.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_veiculo' => 'nullable|integer|exists:veiculos,id',
            'id_prestador' => 'nullable|integer|exists:prestadores,id',
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|min:11|max:15',
            'celular' => 'required|string|max:20',
            'tipo_acesso' => 'required|string|max:40',
            'observacoes' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
        ]);

 
        if ($request->hasFile('image')) {
            $nomeArquivo = $request->file('image')->hashName();
            $request->file('image')->storeAs('visitantes', $nomeArquivo, 'public');
            $data['image'] = $nomeArquivo;
        }

        $visitante = Visitante::create($data);

        if ($visitante) {
            return redirect()->route('index.visitante')->with([
                'success' => true,
                'message' => 'Visitante registrado com sucesso!'
            ]);
        } else {
            return redirect()->route('index.visitante')->with([
                'success' => false,
                'message' => 'Erro ao registrar visitante!'
            ]);
        }

    }

    /**
     * Mostra o formulário para editar um visitante existente.
     */
    public function edit($id)
    {
        $visitante = Visitante::findOrFail($id);
        $veiculos = Veiculo::orderBy('placa')->get();
        $prestadores = Prestador::orderBy('empresa')->get();

        return view('pages.visitantes.register', compact('visitante', 'veiculos', 'prestadores'));
    }

    /**
     * Atualiza um visitante existente.
     */
    public function update(Request $request, $id)
    {
        $visitante = Visitante::findOrFail($id);

        $data = $request->validate([
            'id_veiculo' => 'nullable|exists:veiculos,id',
            'id_prestador' => 'nullable|exists:prestadores,id',
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|min:11|max:15',
            'celular' => 'required|string|max:20',
            'tipo_acesso' => 'required|string|max:40',
            'observacoes' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $nomeArquivo = $request->file('image')->hashName();
            $request->file('image')->storeAs('visitantes', $nomeArquivo, 'public');
            $data['image'] = $nomeArquivo;
        }

        $visitante->update($data);

        return redirect()->route('index.visitante')->with('success', 'Visitante atualizado com sucesso!');
    }

    /**
     * Remove um visitante.
     */
    public function destroy($id)
    {
        $visitante = Visitante::findOrFail($id);

        if ($visitante->image) {
            $path = str_replace('/storage/', '', $visitante->image);
            Storage::disk('public')->delete($path);
        }

        $visitante->delete();

        return redirect()->route('index.visitante')->with('success', 'Visitante removido com sucesso!');
    }

        private function unmask($value)
    {
        return preg_replace('/[^0-9]/', '', $value);
    }
}