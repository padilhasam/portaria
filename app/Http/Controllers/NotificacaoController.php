<?php

namespace App\Http\Controllers;

use App\Models\Notificacao;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\Loggable; // ✅ Trait para logs
use Exception;

class NotificacaoController extends Controller
{
    use Loggable;

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
            ->when($request->filled('data_inicio'), fn($q) => $q->whereDate('notificacoes.created_at', '>=', $request->data_inicio))
            ->when($request->filled('data_fim'), fn($q) => $q->whereDate('notificacoes.created_at', '<=', $request->data_fim))
            ->when($request->filled('criador'), fn($q) => $q->where('notificacoes.id_criador', $request->criador))
            ->when($request->filled('status'), function ($q) use ($request) {
                $request->status === 'lida'
                    ? $q->wherePivot('read', true)
                    : ($request->status === 'nao_lida' ? $q->wherePivot('read', false) : null);
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

        $user->notificacoesRecebidas()->updateExistingPivot($notificacao->id, ['read' => true]);

        $this->registrarLog('UPDATE', 'notificacoes', $notificacao->id, "Notificação marcada como lida pelo usuário {$user->name}");

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

        try {
            $data = $request->only(['title', 'message']);
            $data['id_criador'] = auth()->id();

            if ($request->hasFile('arquivo')) {
                $data['arquivo'] = $request->file('arquivo')->store('notificacoes', 'public');
            }

            $notificacao = Notificacao::create($data);

            $usuarios = User::where('id', '!=', auth()->id())->get();
            $attachData = [];
            foreach ($usuarios as $usuario) {
                $attachData[$usuario->id] = ['read' => false];
            }
            $notificacao->destinatarios()->attach($attachData);

            $this->registrarLog('CREATE', 'notificacoes', $notificacao->id, "Notificação '{$notificacao->title}' criada e enviada para todos os usuários.");

            return redirect()->route('index.notificacao')->with('success', 'Notificação enviada com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('CREATE', 'notificacoes', null, "Erro ao criar notificação", $e->getMessage());
            return back()->with('error', 'Erro ao enviar notificação.');
        }
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

        try {
            $notificacao->update([
                'title' => $request->title,
                'message' => $request->message,
            ]);

            $this->registrarLog('UPDATE', 'notificacoes', $notificacao->id, "Notificação '{$notificacao->title}' atualizada.");

            return redirect()->route('index.notificacao')->with('success', 'Notificação atualizada com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('UPDATE', 'notificacoes', $notificacao->id, "Erro ao atualizar notificação", $e->getMessage());
            return back()->with('error', 'Erro ao atualizar notificação.');
        }
    }

    public function destroy(string $id)
    {
        $notificacao = Notificacao::findOrFail($id);

        if ($notificacao->id_criador !== auth()->id()) {
            abort(403, 'Você não tem permissão para excluir essa notificação.');
        }

        try {
            $titulo = $notificacao->title;
            $notificacao->delete();

            $this->registrarLog('DELETE', 'notificacoes', $id, "Notificação '{$titulo}' removida com sucesso.");

            return redirect()->route('index.notificacao')->with('success', 'Notificação excluída.');
        } catch (Exception $e) {
            $this->registrarLog('DELETE', 'notificacoes', $id, "Erro ao excluir notificação", $e->getMessage());
            return back()->with('error', 'Erro ao excluir notificação.');
        }
    }

    public function marcarComoLida($notificacaoId)
    {
        auth()->user()->notificacoesRecebidas()->updateExistingPivot($notificacaoId, ['read' => true]);

        $this->registrarLog('UPDATE', 'notificacoes', $notificacaoId, "Notificação marcada como lida.");

        return back()->with('success', 'Notificação marcada como lida.');
    }

    public function marcarTodasComoLidas()
    {
        $user = auth()->user();
        $ids = $user->notificacoesRecebidas()->wherePivot('read', false)->pluck('notificacoes.id');

        if ($ids->isEmpty()) {
            return back()->with('info', 'Nenhuma notificação para marcar como lida.');
        }

        foreach ($ids as $id) {
            $user->notificacoesRecebidas()->updateExistingPivot($id, ['read' => true]);
            $this->registrarLog('UPDATE', 'notificacoes', $id, "Notificação marcada como lida em ação em massa.");
        }

        return back()->with('success', 'Todas as notificações foram marcadas como lidas.');
    }

    public function responder(Request $request, string $id)
    {
        $request->validate([
            'resposta' => 'required|string|max:1000',
        ]);

        try {
            $notificacao = Notificacao::findOrFail($id);
            $destinatario = $notificacao->criador;
            $remetente = auth()->user();

            $resposta = Notificacao::create([
                'title' => 'Resposta à sua notificação: ' . $notificacao->title,
                'message' => "Resposta de {$remetente->name}:\n\n" . $request->resposta,
                'id_criador' => $remetente->id,
                'id_resposta_de' => $notificacao->id,
            ]);

            $resposta->destinatarios()->attach([$destinatario->id => ['read' => false]]);

            $this->registrarLog('CREATE', 'notificacoes', $resposta->id, "Resposta enviada para a notificação '{$notificacao->title}'.");

            return back()->with('success', 'Sua resposta foi enviada com sucesso!');
        } catch (Exception $e) {
            $this->registrarLog('CREATE', 'notificacoes', null, "Erro ao responder notificação", $e->getMessage());
            return back()->with('error', 'Erro ao enviar resposta.');
        }
    }

    public function verRespostas($id)
    {
        $notificacao = Notificacao::select("*")->find($id);
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
