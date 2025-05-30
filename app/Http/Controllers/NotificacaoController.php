<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    /**
     * Lista todas as notificações.
     */
    public function index()
    {
        $notificacoes = Notificacao::latest()->paginate(10);
        return view('pages.notificacoes.index', compact('notificacoes'));
    }

    /**
     * Exibe uma notificação específica.
     */
    public function show(string $id)
    {
        $notificacao = Notificacao::findOrFail($id);

        // Marca como lida se ainda não foi
        if (!$notificacao->read) {
            $notificacao->update(['read' => true]);
        }

        return view('pages.notificacoes.show', compact('notificacao'));
    }

    /**
     * Exibe o formulário de criação.
     */
    public function create()
    {
        return view('pages.notificacoes.create');
    }

    /**
     * Salva uma nova notificação.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Notificacao::create([
            'title' => $request->title,
            'message' => $request->message,
            'read' => false,
        ]);

        return redirect()->route('pages.notificacoes.index')->with('success', 'Notificação criada com sucesso!');
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(string $id)
    {
        $notificacao = Notificacao::findOrFail($id);
        return view('pages.notificacoes.edit', compact('notificacao'));
    }

    /**
     * Atualiza uma notificação existente.
     */
    public function update(Request $request, string $id)
    {
        $notificacao = Notificacao::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'read' => 'required|boolean',
        ]);

        $notificacao->update($request->only(['title', 'message', 'read']));

        return redirect()->route('pages.notificacoes.index')->with('success', 'Notificação atualizada!');
    }

    /**
     * Remove uma notificação.
     */
    public function destroy(string $id)
    {
        $notificacao = Notificacao::findOrFail($id);
        $notificacao->delete();

        return redirect()->route('pages.notificacoes.index')->with('success', 'Notificação excluída.');
    }
}