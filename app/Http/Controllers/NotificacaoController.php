<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use App\Models\User;
use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    /**
     * Lista de notificações para o usuário autenticado.
     */
    public function index()
    {
        $user = auth()->user();

        $notificacoes = $user->notificacoesRecebidas()
            ->latest()
            ->paginate(10);

        return view('pages.notificacoes.index', compact('notificacoes'));
    }

    /**
     * Detalhes da notificação e marca como lida.
     */
    public function show(string $id)
    {
        $user = auth()->user();

        $notificacao = $user->notificacoesRecebidas()->findOrFail($id);

        $user->notificacoesRecebidas()
            ->updateExistingPivot($notificacao->id, ['read' => true]);

        return redirect()->route('index.notificacao')
            ->with('success', 'Notificação marcada como lida.');
    }

    /**
     * Formulário de criação de notificação.
     */
    public function create()
    {
        // Não precisamos mais passar usuários para a view
        return view('pages.notificacoes.register');
    }

    /**
     * Armazena uma nova notificação.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Cria a notificação com o criador vinculado
        $notificacao = Notificacao::create([
            'title' => $validated['title'],
            'message' => $validated['message'],
            'id_criador' => auth()->id(), // Associa o criador
        ]);

        // Pega todos os usuários, exceto o criador
        $usuarios = User::where('id', '!=', auth()->id())->get();

        // Prepara dados para o attach na tabela pivot, com 'read' = false
        $attachData = [];
        foreach ($usuarios as $usuario) {
            $attachData[$usuario->id] = ['read' => false];
        }

        // Associa todos os usuários (exceto o criador) à notificação
        $notificacao->destinatarios()->attach($attachData);

        return redirect()->route('index.notificacao')
            ->with('success', 'Notificação enviada para todos os usuários, exceto você.');
    }

    /**
     * Formulário de edição.
     */
    public function edit(string $id)
    {
        $notificacao = Notificacao::findOrFail($id);

        // Não passamos usuários, pois não editamos destinatários mais
        return view('pages.notificacoes.register', compact('notificacao'));
    }

    /**
     * Atualiza uma notificação existente.
     */
    public function update(Request $request, string $id)
    {
        $notificacao = Notificacao::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $notificacao->update([
            'title' => $validated['title'],
            'message' => $validated['message'],
        ]);

        // Não atualizamos destinatários, pois é para todos sempre

        return redirect()->route('index.notificacao')->with('success', 'Notificação atualizada com sucesso!');
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
    public function marcarComoLida($notificacaoId)
    {
        auth()->user()
            ->notificacoesRecebidas()
            ->updateExistingPivot($notificacaoId, ['read' => true]);

        return back()->with('success', 'Notificação marcada como lida.');
    }

    /**
     * Marca todas como lidas.
     */
    public function marcarTodasComoLidas()
    {
        $user = auth()->user();

        $ids = $user->notificacoesRecebidas()
            ->wherePivot('read', false)
            ->pluck('notificacoes.id');

        if ($ids->isEmpty()) {
            return back()->with('info', 'Nenhuma notificação para marcar como lida.');
        }

        foreach ($ids as $id) {
            $user->notificacoesRecebidas()
                ->updateExistingPivot($id, ['read' => true]);
        }

        return back()->with('success', 'Todas as notificações foram marcadas como lidas.');
    }

    public function responder(Request $request, string $id)
    {
        $request->validate([
            'resposta' => 'required|string|max:1000',
        ]);

        $notificacao = Notificacao::findOrFail($id);
        $destinatario = $notificacao->creator; // Criador da notificação
        $remetente = auth()->user(); // Quem está respondendo

        // Envia uma nova notificação para o criador com a resposta
        $resposta = Notificacao::create([
            'title' => 'Resposta à sua notificação: ' . $notificacao->title,
            'message' => "Resposta de {$remetente->name}:\n\n" . $request->resposta,
            'user_id' => $remetente->id, // quem criou a resposta
        ]);

        // Associa somente o criador original como destinatário da resposta
        $resposta->destinatarios()->attach([
            $destinatario->id => ['read' => false],
        ]);

        return redirect()->back()->with('success', 'Sua resposta foi enviada com sucesso!');
    }
}