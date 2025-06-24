@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-2">
            ⚙️ Configurações
        </h3>
    </div>
</header>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-4">👤 Configurações de Perfil</h5>

        <form action="{{ route('perfil.update.configuracao') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">E-mail</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Nova Senha</label>
                <input type="password" name="password" class="form-control" placeholder="Deixe em branco para não alterar">
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Salvar Perfil</button>
            </div>
        </form>
    </div>
</div>

@can('isAdmin') {{-- Só mostra para administradores --}}
<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
        <h5 class="fw-bold mb-4">🛠️ Configurações do Sistema</h5>

        <form action="{{ route('sistema.update.configuracao') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">Nome do Sistema</label>
                <input type="text" name="nome_sistema" class="form-control" value="{{ old('nome_sistema', $config->nome_sistema ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email de Contato</label>
                <input type="email" name="email_contato" class="form-control" value="{{ old('email_contato', $config->email_contato ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Logo do Sistema</label>
                <input type="file" name="logo" class="form-control">
                @if(!empty($config->logo))
                    <img src="{{ asset('storage/'.$config->logo) }}" alt="Logo atual" class="mt-2" style="height: 50px;">
                @endif
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="notificacoes_email" class="form-check-input" id="notificacoes_email"
                    {{ old('notificacoes_email', $config->notificacoes_email ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="notificacoes_email">Ativar notificações por e-mail</label>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="modo_manutencao" class="form-check-input" id="modo_manutencao"
                    {{ old('modo_manutencao', $config->modo_manutencao ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="modo_manutencao">Ativar modo manutenção</label>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Salvar Configurações do Sistema</button>
            </div>
        </form>
    </div>
</div>
@endcan
@endsection
