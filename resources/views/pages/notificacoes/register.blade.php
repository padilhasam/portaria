@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $notificacao = $notificacao ?? null;
    $edit = isset($notificacao);
@endphp

{{-- Alertas de feedback --}}
@if(session('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
@endif

@if(session('error'))
    <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
@endif

@if($errors->any())
    <div id="validation-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
@endif

{{-- Cabeçalho --}}
<header class="mb-2 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container" style="width: 32px; height: 32px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.628-14.885A1.5 1.5 0 0 1 10.5 2h.5a1.5 1.5 0 0 1 1.5 1.5v.086c0 .11.009.219.026.327C13.127 6.25 14 7.5 14 9v1l.447.894a.5.5 0 0 1-.447.75H2a.5.5 0 0 1-.447-.75L2 10V9c0-1.5.873-2.75 1.474-5.087A1.5 1.5 0 0 1 5.5 2h.5a1.5 1.5 0 0 1 1.372-.885z"/>
            </svg>
        </span>
        {{ $edit ? 'Editar Notificação' : 'Cadastrar Notificação' }}
    </h3>
    <div>
        <a href="{{ route('index.notificacao') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg> Voltar
        </a>
    </div>
</header>

{{-- Formulário --}}
<div class="container py-4">
    <form action="{{ $edit ? route('update.notificacao', $notificacao->id) : route('store.notificacao') }}" method="POST">
        @csrf
        @if($edit)
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $notificacao->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Mensagem</label>
            <textarea id="message" name="message" class="form-control" rows="4" style="resize: none" required>{{ old('message', $notificacao->message ?? '') }}</textarea>
        </div>

        <div class="alert alert-info fw-semibold">
            Esta notificação será enviada automaticamente para <u>todos os usuários cadastrados</u>.
        </div>

        <button type="submit" class="btn btn-success">
            {{ $edit ? 'Atualizar Notificação' : 'Enviar Notificação' }}
        </button>
    </form>
</div>

@endsection