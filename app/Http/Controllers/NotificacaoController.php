<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use App\Models\User;
use Illuminate\Http\Request;

class NotificacaoController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = $user->notificacoesRecebidas()
            ->with('criador')
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

        $usuariosCriadores = User::whereIn('id', function ($q) {
            $q->select('id_criador')->from('notificacoes')->distinct();
        })->get();

        return view('pages.notificacoes.index', compact('notificacoes', 'usuariosCriadores'));
    }

    public function show(string $id)
    {
        $user = auth()->user();
        $notificacao = $user->notificacoesRecebidas()->findOrFail($id);

        $user->notificacoesRecebidas()
            ->updateExistingPivot($notificacao->id, ['read' => true]);

        return redirect()->route('index.notificacao')->with('success', 'Notificação marcada como lida.');
    }

    public function create()
    {
        return view('pages.notificacoes.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'arquivo' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip|max:5120',
        ]);

        $data = $request->only(['title', 'message']);
        $data['id_criador'] = auth()->id();

        if ($request->hasFile('arquivo')) {
            $nomeArquivo = $request->file('arquivo')->hashName();
            $request->file('arquivo')->storeAs('notificacoes', $nomeArquivo, 'public');
            $data['arquivo'] = $nomeArquivo;
        }

        $notificacao = Notificacao::create($data);

        $usuarios = User::where('id', '!=', auth()->id())->get();

        $attachData = [];
        foreach ($usuarios as $usuario) {
            $attachData[$usuario->id] = ['read' => false];
        }

        $notificacao->destinatarios()->attach($attachData);

        return redirect()->route('index.notificacao')
            ->with('success', 'Notificação enviada para todos os usuários, exceto você.');
    }

    public function edit(string $id)
    {
        $notificacao = Notificacao::findOrFail($id);
        return view('pages.notificacoes.register', compact('notificacao'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'arquivo' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip|max:5120',
        ]);

        $notificacao = Notificacao::findOrFail($id);

        $notificacao->update([
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return redirect()->route('index.notificacao')->with('success', 'Notificação atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $notificacao = Notificacao::findOrFail($id);

        if ($notificacao->id_criador !== auth()->id()) {
            abort(403, 'Você não tem permissão para excluir essa notificação.');
        }

        $notificacao->delete();

        return redirect()->route('index.notificacao')->with('success', 'Notificação excluída.');
    }

    public function marcarComoLida($notificacaoId)
    {
        auth()->user()
            ->notificacoesRecebidas()
            ->updateExistingPivot($notificacaoId, ['read' => true]);

        return back()->with('success', 'Notificação marcada como lida.');
    }

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
            $user->notificacoesRecebidas()->updateExistingPivot($id, ['read' => true]);
        }

        return back()->with('success', 'Todas as notificações foram marcadas como lidas.');
    }

    public function responder(Request $request, string $id)
    {
        $request->validate([
            'resposta' => 'required|string|max:1000',
        ]);

        $notificacao = Notificacao::findOrFail($id);
        $destinatario = $notificacao->criador;
        $remetente = auth()->user();

        $resposta = Notificacao::create([
            'title' => 'Resposta à sua notificação: ' . $notificacao->title,
            'message' => "Resposta de {$remetente->name}:\n\n" . $request->resposta,
            'id_criador' => $remetente->id,
            'id_resposta_de' => $notificacao->id,
        ]);

        $resposta->destinatarios()->attach([
            $destinatario->id => ['read' => false],
        ]);

        return redirect()->back()->with('success', 'Sua resposta foi enviada com sucesso!');
    }

    public function verRespostas($id)
    {
        $notificacao = Notificacao::with(['respostas.criador'])
            ->where('id_criador', auth()->id())
            ->findOrFail($id);

        return view('pages.notificacoes.respostas', compact('notificacao'));
    }

    public function respostasJson($id)
    {
        $notificacao = Notificacao::with(['respostas.criador'])->findOrFail($id);

        return response()->json([
            'respostas' => $notificacao->respostas->map(function ($resposta) {
                return [
                    'id' => $resposta->id,
                    'mensagem' => $resposta->mensagem,
                    'usuario' => $resposta->criador->nome ?? '—',
                    'data' => $resposta->created_at->format('d/m/Y H:i'),
                    'sou_eu' => auth()->id() === $resposta->id_criador,
                ];
            }),
        ]);
    }
}