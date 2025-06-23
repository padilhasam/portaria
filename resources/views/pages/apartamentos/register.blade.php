@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($apartamento) ? true : false;
@endphp

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

<header class="mb-2 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container" style="width: 32px; height: 32px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-house-add-fill" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 1 1-1 0v-1h-1a.5.5 0 1 1 0-1h1v-1a.5.5 0 0 1 1 0"/>
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                <path d="m8 3.293 4.712 4.712A4.5 4.5 0 0 0 8.758 15H3.5A1.5 1.5 0 0 1 2 13.5V9.293z"/>
              </svg>
        </span>
        {{ $edit ? "Alterar Apartamento" : "Cadastrar Apartamento" }}
    </h3>
    <div class="d-flex align-items-center gap-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
              </svg> Voltar
        </a>
    </div>
</header>

<div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">Dados do Apartamento</div>
                <div class="card-body">

                    <div class="card shadow-sm p-4">
                        <form action="{{ $edit ? route('update.apartamento', ['id' => $apartamento->id, 'from' => request()->query('from')]) : route('store.apartamento', ['from' => request()->query('from')]) }}" method="POST" novalidate>
                            @csrf
                            @if ($edit)
                                @method('PUT')
                            @endif

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="numero" class="form-label fw-semibold">Número Apartamento <span class="text-danger">*</span></label>
                                    <input name="numero" type="text" class="form-control rounded-pill border-dark @error('numero') is-invalid @enderror" id="numero" placeholder="Ex: 101" value="{{ old('numero', $edit ? $apartamento->numero : '') }}" required autofocus>
                                    @error('numero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="bloco" class="form-label fw-semibold">Bloco <span class="text-danger">*</span></label>
                                    <input name="bloco" type="text" class="form-control rounded-pill border-dark @error('bloco') is-invalid @enderror" id="bloco" placeholder="Ex: A" value="{{ old('bloco', $edit ? $apartamento->bloco : '') }}" required>
                                    @error('bloco')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="vaga" class="form-label fw-semibold">Número da Vaga <span class="text-danger">*</span></label>
                                    <input name="vaga" type="text" class="form-control rounded-pill border-dark @error('vaga') is-invalid @enderror" id="vaga" placeholder="Ex: 01 ou 01A" value="{{ old('vaga', $edit ? $apartamento->vaga : '') }}" required>
                                    @error('vaga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="ramal" class="form-label fw-semibold">Ramal <span class="text-danger">*</span></label>
                                    <input name="ramal" type="text" class="form-control rounded-pill border-dark @error('ramal') is-invalid @enderror" id="ramal" placeholder="Ex: 205" value="{{ old('ramal', $edit ? $apartamento->ramal : '') }}" required>
                                    @error('ramal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="status_vaga" class="form-label fw-semibold">Status da Vaga <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-pill border-dark @error('status_vaga') is-invalid @enderror" name="status_vaga" id="status_vaga" required>
                                        <option value="" disabled {{ old('status_vaga', $edit ? $apartamento->status_vaga : '') === null ? 'selected' : '' }}>Selecione o status da vaga...</option>
                                        <option value="livre" {{ old('status_vaga', $edit ? $apartamento->status_vaga : '') == "livre" ? "selected" : "" }}>Livre</option>
                                        <option value="ocupada" {{ old('status_vaga', $edit ? $apartamento->status_vaga : '') == "ocupada" ? "selected" : "" }}>Ocupada</option>
                                        <option value="emprestada" {{ old('status_vaga', $edit ? $apartamento->status_vaga : '') == "emprestada" ? "selected" : "" }}>Emprestada</option>
                                        <option value="alugada" {{ old('status_vaga', $edit ? $apartamento->status_vaga : '') == "alugada" ? "selected" : "" }}>Alugada</option>
                                    </select>
                                    @error('status_vaga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="observacoes" class="form-label fw-semibold">Observações</label>
                                    <textarea class="form-control rounded-4 border-dark @error('observacoes') is-invalid @enderror" name="observacoes" id="observacoes" rows="4" style="resize: none;">{{ old('observacoes', $edit ? $apartamento->observacoes : '') }}</textarea>
                                    @error('observacoes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="submit" class="btn btn-success rounded-pill px-4">{{ $edit ? "Alterar Apartamento" : "Salvar" }}</button>
                                <button type="reset" class="btn btn-outline-danger rounded-pill px-4" onclick="return confirm('Tem certeza que deseja limpar o formulário?')">Limpar</button>
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">Cancelar</a>
                            </div>
                        </form>
                    </div>
        </div>
    </div>
</div>

@endsection
