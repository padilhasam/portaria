@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm">
    {{-- Linha do título + botão --}}
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-3">
        <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3" style="font-size: 1.75rem;">
            <span class="icon-container d-flex align-items-center justify-content-center"
                  style="width: 36px; height: 36px; background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                <!-- SVG do ícone -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-car-front-fill" viewBox="0 0 16 16">
                    <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2m10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17s3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z"/>
                </svg>
            </span>
            Histórico de Respostas
        </h3>
    </div>
</header>

<div class="card shadow-sm p-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light fw-bold">📨 Histórico de Respostas</div>
            <div class="card-body">

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
        </div>
    </div>
</div>
@endsection
