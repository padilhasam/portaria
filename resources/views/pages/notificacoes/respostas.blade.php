@extends('layouts.dashboard')

@section('page_dashboard')

<div class="container">
    <h3 class="mb-4">📨 Histórico de Respostas</h3>

    <!-- Notificação original -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $notificacao->title }}</h5>
            <p class="card-text" style="white-space: pre-wrap;">{{ $notificacao->message }}</p>

            @if($notificacao->arquivo)
                <p class="mt-2">
                    <strong>Anexo:</strong>
                    <a href="{{ asset('storage/notificacoes/' . $notificacao->arquivo) }}" target="_blank" download class="ms-2">
                        📎 Baixar Arquivo
                    </a>
                </p>
            @endif

            <small class="text-muted">Enviada em {{ $notificacao->created_at->format('d/m/Y H:i') }}</small>
        </div>
    </div>

    <!-- Respostas -->
    <h5>💬 Conversa:</h5>
    @forelse($notificacao->respostas as $resposta)
        <div @class([
            'card mb-3',
            'border-success' => $resposta->id_criador === auth()->id(),
            'border-primary' => $resposta->id_criador !== auth()->id(),
        ])>
            <div class="card-header bg-light d-flex justify-content-between">
                <span>
                    <strong>{{ $resposta->criador->nome }}</strong>
                    @if($resposta->id_criador === auth()->id())
                        <span class="badge bg-success ms-2">Você</span>
                    @endif
                </span>
                <span class="text-muted">{{ $resposta->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="card-body">
                <p class="mb-2" style="white-space: pre-line;">{{ $resposta->message }}</p>

                @if($resposta->arquivo)
                    <p class="mt-2">
                        <strong>Anexo:</strong>
                        <a href="{{ asset('storage/notificacoes/' . $resposta->arquivo) }}" target="_blank" download>
                            📎 Baixar Arquivo
                        </a>
                    </p>
                @endif
            </div>
        </div>
    @empty
        <p class="text-muted">Nenhuma resposta registrada ainda.</p>
    @endforelse

    <!-- Formulário de resposta -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Responder</h5>
            <form method="POST" action="{{ route('notificacoes.enviar_resposta', $notificacao->id) }}" enctype="multipart/form-data">
                @csrf

                @error('resposta')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div class="mb-3">
                    <label for="resposta" class="form-label">Mensagem:</label>
                    <textarea name="resposta" id="resposta" class="form-control" rows="4" required placeholder="Digite sua resposta aqui..." aria-label="Mensagem de resposta"></textarea>
                </div>

                <div class="mb-3">
                    <label for="arquivo" class="form-label">Anexar Arquivo (opcional):</label>
                    <input type="file" name="arquivo" id="arquivo" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                </div>

                <button type="submit" class="btn btn-primary">📩 Enviar Resposta</button>
                <a href="{{ route('index.notificacao') }}" class="btn btn-secondary ms-2">⬅️ Voltar</a>
            </form>
        </div>
    </div>
</div>
@endsection