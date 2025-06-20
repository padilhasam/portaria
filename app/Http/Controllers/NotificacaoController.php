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
    public function index(Request $request)
    {
         $user = auth()->user();

        $query = $user->notificacoesRecebidas()
            ->with('criador') // já traz o nome do criador
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('message', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('data_inicio'), function ($q) use ($request) {
                $q->whereDate('notificacoes.created_at', '>=', $request->data_inicio);
            })
            ->when($request->filled('data_fim'), function ($q) use ($request) {
                $q->whereDate('notificacoes.created_at', '<=', $request->data_fim);
            })
            ->when($request->filled('criador'), function ($q) use ($request) {
                $q->where('notificacoes.id_criador', $request->criador);
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                if ($request->status === 'lida') {
                    $q->wherePivot('read', true);
                } elseif ($request->status === 'nao_lida') {
                    $q->wherePivot('read', false);
                }
            })
            ->orderByDesc('notificacoes.created_at');

        $notificacoes = $query->paginate(10)->withQueryString();

        // Para popular o filtro de criadores
        $usuariosCriadores = User::whereIn('id', function ($q) {
            $q->select('id_criador')->from('notificacoes')->distinct();
        })->get();

        return view('pages.notificacoes.index', compact('notificacoes', 'usuariosCriadores'));
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
        'arquivo' => 'nullable|file|max:5120', // até 5MB
        ]);

        // Adiciona id_criador ao array
        $validated['id_criador'] = auth()->id();

        // Se houver arquivo, faz upload e adiciona ao array
        if ($request->hasFile('arquivo')) {
            $nomeArquivo = $request->file('arquivo')->hashName();
            $request->file('arquivo')->storeAs('notificacoes', $nomeArquivo, 'public');
            $validated['arquivo'] = $nomeArquivo;
        }

        // Cria a notificação com todos os dados validados
        $notificacao = Notificacao::create($validated);

        // Seleciona todos os usuários, exceto o criador
        $usuarios = User::where('id', '!=', auth()->id())->get();

        // Cria os dados para a tabela pivot notificacao_user
        $attachData = [];
        foreach ($usuarios as $usuario) {
            $attachData[$usuario->id] = ['read' => false];
        }

        // Associa usuários à notificação
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
            'arquivo' => 'nullable|file|max:5120', // até 5MB
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
        $destinatario = $notificacao->criador; // Criador da notificação
        $remetente = auth()->user(); // Quem está respondendo

        // Envia uma nova notificação para o criador com a resposta
        $resposta = Notificacao::create([
            'title' => 'Resposta à sua notificação: ' . $notificacao->title,
            'message' => "Resposta de {$remetente->name}:\n\n" . $request->resposta,
            'id_criador' => $remetente->id, // quem criou a resposta
            'id_resposta_de' => $notificacao->id,
        ]);

        // Associa somente o criador original como destinatário da resposta
        $resposta->destinatarios()->attach([
            $destinatario->id => ['read' => false],
        ]);

        return redirect()->back()->with('success', 'Sua resposta foi enviada com sucesso!');
    }

    public function verRespostas($id)
    {
        $notificacao = Notificacao::with(['respostas.criador']) // já carrega quem respondeu
            ->where('id_criador', auth()->id()) // só o criador pode ver
            ->findOrFail($id);

        return view('pages.notificacoes.respostas', compact('notificacao'));
    }
}