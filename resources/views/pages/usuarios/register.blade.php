@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($usuario);
@endphp

@include('components.alerts')

<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container" style="width: 32px; height: 32px;">
            <!-- Ícone SVG -->
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-house-add-fill" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 1 1-1 0v-1h-1a.5.5 0 1 1 0-1h1v-1a.5.5 0 0 1 1 0"/>
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                <path d="m8 3.293 4.712 4.712A4.5 4.5 0 0 0 8.758 15H3.5A1.5 1.5 0 0 1 2 13.5V9.293z"/>
            </svg>
        </span>
        {{ $edit ? "Alterar Usuário" : "Cadastrar Usuário" }}
    </h3>
    <div>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm rounded-pill d-flex align-items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg>
            Voltar
        </a>
    </div>
</header>

<div class="card shadow-sm p-4">
    <form action="{{ $edit ? route('update.usuario', ['id' => $usuario->id]) : route('store.usuario') }}" method="POST" novalidate>
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">Dados do Usuário</div>
                <div class="card-body">

                    <form action="{{ $edit ? route('update.usuario', ['id' => $usuario->id]) : route('store.usuario') }}" method="POST" novalidate>
                        @csrf
                        @if ($edit)
                            @method('PUT')
                        @endif

                        <div class="row g-3">
                            <div class="col-lg-4 col-md-6">
                                <label for="nome" class="form-label fw-semibold">Nome Completo<span class="text-danger">*</span></label>
                                <input name="nome" type="text" id="nome" required
                                    class="form-control rounded-pill @error('nome') is-invalid @enderror"
                                    placeholder="Nome Completo"
                                    value="{{ old('nome', $edit ? $usuario->nome : '') }}">
                                @error('nome')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="documento" class="form-label fw-semibold">CPF<span class="text-danger">*</span></label>
                                <input name="documento" type="text" id="documento" required
                                    class="form-control rounded-pill @error('documento') is-invalid @enderror"
                                    placeholder="CPF"
                                    value="{{ old('documento', $edit ? $usuario->documento : '') }}">
                                @error('documento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="nascimento" class="form-label fw-semibold">Data de Nascimento<span class="text-danger">*</span></label>
                                <input name="nascimento" type="date" id="nascimento" required
                                    class="form-control rounded-pill @error('nascimento') is-invalid @enderror"
                                    value="{{ old('nascimento', $edit ? $usuario->nascimento : '') }}">
                                @error('nascimento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="celular" class="form-label fw-semibold">Celular<span class="text-danger">*</span></label>
                                <input name="celular" type="text" id="celular" required
                                    class="form-control rounded-pill @error('celular') is-invalid @enderror"
                                    placeholder="Whatsapp"
                                    value="{{ old('celular', $edit ? $usuario->celular : '') }}">
                                @error('celular')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="user" class="form-label fw-semibold">Usuário<span class="text-danger">*</span></label>
                                <input name="user" type="text" id="user" required
                                    class="form-control rounded-pill @error('user') is-invalid @enderror"
                                    placeholder="Digite um usuário"
                                    value="{{ old('user', $edit ? $usuario->user : '') }}">
                                @error('user')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="email" class="form-label fw-semibold">Email<span class="text-danger">*</span></label>
                                <input name="email" type="email" id="email" required
                                    class="form-control rounded-pill @error('email') is-invalid @enderror"
                                    placeholder="Digite um email válido"
                                    value="{{ old('email', $edit ? $usuario->email : '') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="password" class="form-label fw-semibold">
                                    {{ $edit ? 'Nova Senha (opcional)' : 'Senha' }}
                                    @unless($edit)
                                        <span class="text-danger">*</span>
                                    @endunless
                                </label>
                                <input
                                    name="password"
                                    type="password"
                                    id="password"
                                    @unless($edit) required @endunless
                                    class="form-control rounded-pill @error('password') is-invalid @enderror"
                                    placeholder="Digite uma senha segura">
                                @if($edit)
                                    <small class="text-muted">Deixe em branco para manter a senha atual.</small>
                                @endif
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    {{ $edit ? 'Confirmar Nova Senha' : 'Repetir Senha' }}
                                    @unless($edit)
                                        <span class="text-danger">*</span>
                                    @endunless
                                </label>
                                <input
                                    name="password_confirmation"
                                    type="password"
                                    id="password_confirmation"
                                    @unless($edit) required @endunless
                                    class="form-control rounded-pill @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Confirme a senha">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" required
                                    class="form-select rounded-pill @error('status') is-invalid @enderror">
                                    <option value="" disabled {{ old('status', $edit ? strtolower($usuario->status) : '') === '' ? 'selected' : '' }}>Selecione</option>
                                    <option value="ativo" {{ old('status', $edit ? strtolower($usuario->status) : '') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                                    <option value="bloqueado" {{ old('status', $edit ? strtolower($usuario->status) : '') === 'bloqueado' ? 'selected' : '' }}>Bloqueado</option>
                                    <option value="férias" {{ old('status', $edit ? strtolower($usuario->status) : '') === 'férias' ? 'selected' : '' }}>Férias</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="tipo" class="form-label fw-semibold">Tipo <span class="text-danger">*</span></label>
                                <select name="tipo" id="tipo" required
                                    class="form-select rounded-pill @error('tipo') is-invalid @enderror">
                                    <option value="" disabled {{ old('tipo', $edit ? $usuario->tipo : '') === '' ? 'selected' : '' }}>Selecione</option>
                                    <option value="administrador" {{ old('tipo', $edit ? $usuario->tipo : '') === 'administrador' ? 'selected' : '' }}>Administrador</option>
                                    <option value="padrao" {{ old('tipo', $edit ? $usuario->tipo : '') === 'padrao' ? 'selected' : '' }}>Padrão</option>
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-3">
                            <button type="submit" class="btn btn-success rounded-pill px-4">{{ $edit ? 'Alterar' : 'Salvar' }}</button>
                            <button type="reset" class="btn btn-outline-danger rounded-pill px-4" onclick="return confirm('Tem certeza que deseja limpar o formulário?')">Limpar</button>
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </form>
</div>

@endsection
