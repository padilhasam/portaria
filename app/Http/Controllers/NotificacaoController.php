<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    /**
     * Exibe a lista de notificações com paginação.
     */
    public function index()
    {
        $notificacoes = Notificacao::latest()->paginate(10);
        return view('pages.notificacoes.index', compact('notificacoes'));
    }

    /**
     * Exibe os detalhes de uma notificação específica.
     */
    public function show(string $id)
    {
        $notificacao = Notificacao::findOrFail($id);

        // Marca como lida automaticamente ao visualizar
        if (!$notificacao->read) {
            $notificacao->update(['read' => true]);
        }

        return view('pages.notificacoes.show', compact('notificacao'));
    }

    /**
     * Formulário para criar uma nova notificação.
     */
    public function create()
    {
        return view('pages.notificacoes.register');
    }

    /**
     * Armazena uma nova notificação.
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

        return redirect()->route('index.notificacao')->with('success', 'Notificação criada com sucesso!');
    }

    /**
     * Formulário para editar uma notificação.
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

        return redirect()->route('index.notificacao')->with('success', 'Notificação atualizada!');
    }

    /**
     * Remove uma notificação.
     */
    public function destroy(string $id)
    {
        $notificacao = Notificacao::findOrFail($id);
        $notificacao->delete();

        return redirect()->route('index.notificacao')->with('success', 'Notificação excluída.');
    }

    /**
     * Marca uma notificação como lida.
     */
    public function marcarComoLida(string $id)
    {
        $notificacao = Notificacao::findOrFail($id);
        $notificacao->marcarComoLida();

        return redirect()->back()->with('success', 'Notificação marcada como lida.');
    }

    /**
     * Marca todas as notificações como lidas.
     */
    public function marcarTodasComoLidas()
    {
        Notificacao::naoLidas()->update(['read' => true]);
        return redirect()->back()->with('success', 'Todas as notificações foram marcadas como lidas.');
    }
}