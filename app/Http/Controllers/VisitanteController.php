<?php

namespace App\Http\Controllers;

use App\Models\Visitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisitanteController extends Controller
{
    /**
     * Exibe a listagem de visitantes.
     */
    public function index()
    {
        $visitantes = Visitante::orderBy('created_at', 'desc')->paginate(10);

        return view('pages.visitantes.index', compact('visitantes'));
    }

    /**
     * Mostra o formulário de cadastro de visitante.
     */
    public function create()
    {
        return view('pages.visitantes.register');
    }

    /**
     * Salva um novo visitante.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:50',
            'documento' => 'required|string|min:11|max:14',
            'telefone' => 'nullable|string|max:20',
            'empresa' => 'nullable|string|max:50',
            'veiculo' => 'nullable|string|max:30',
            'placa' => 'nullable|string|max:12',
            'tipo_acesso' => 'required|string|max:40',
            'observacao' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $caminho = $request->file('image')->store('visitantes', 'public');
            $data['image'] = Storage::url($caminho);
        }

        $visitante = Visitante::create($data);

        if ($visitante) {
            return redirect()->route('index.visitante')->with('success', 'Visitante cadastrado com sucesso!');
        } else {
            return redirect()->route('index.visitante')->with('error', 'Erro ao cadastrar visitante.');
        }
    }

    /**
     * Mostra o formulário para editar um visitante existente.
     */
    public function edit($id)
    {
        $visitante = Visitante::findOrFail($id);

        return view('pages.visitantes.register', compact('visitante'));
    }

    /**
     * Atualiza um visitante existente.
     */
    public function update(Request $request, $id)
    {
        $visitante = Visitante::findOrFail($id);

        $data = $request->validate([
            'nome' => 'required|string|max:50',
            'documento' => 'required|string|min:11|max:14',
            'telefone' => 'nullable|string|max:20',
            'empresa' => 'nullable|string|max:50',
            'veiculo' => 'nullable|string|max:30',
            'placa' => 'nullable|string|max:12',
            'tipo_acesso' => 'required|string|max:40',
            'observacao' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $caminho = $request->file('image')->store('visitantes', 'public');
            $data['image'] = Storage::url($caminho);
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
}