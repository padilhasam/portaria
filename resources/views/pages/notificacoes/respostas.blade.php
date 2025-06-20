@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📨 Respostas da Notificação</h3>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ $notificacao->title }}</h5>
            <p class="card-text">{{ $notificacao->message }}</p>
            <small class="text-muted">Enviada em {{ $notificacao->created_at->format('d/m/Y H:i') }}</small>
        </div>
    </div>

    <h5>💬 Respostas:</h5>
    @forelse($notificacao->respostas as $resposta)
        <div class="card mb-3">
            <div class="card-header bg-light d-flex justify-content-between">
                <span><strong>{{ $resposta->criador->name }}</strong></span>
                <span class="text-muted">{{ $resposta->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $resposta->message }}</p>
            </div>
        </div>
    @empty
        <p class="text-muted">Nenhuma resposta registrada ainda.</p>
    @endforelse

    <a href="{{ route('index.notificacao') }}" class="btn btn-secondary mt-3">⬅️ Voltar</a>
</div>
@endsection