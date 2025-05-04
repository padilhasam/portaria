@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($visitante) ? true : false;
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
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-vcard-fill" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0"/>
              </svg>
        </span>
        {{ $edit ? "Editar Visitante" : "Cadastrar Visitante" }}
    </h3>
    <div>
        <a href="{{ route('index.visitante') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
              </svg> Voltar
        </a>
    </div>
</header>

<div class="card shadow-sm p-4">
    <form action="{{ $edit ? route('update.visitante', ['id' => $visitante->id]) : route('store.visitante') }}" method="POST" enctype="multipart/form-data" id="registroForm">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="row g-4">
            <div class="col-lg-9">
                <div class="row g-3">
                    @foreach ([
                        ['nome', 'Nome'],
                        ['documento', 'CPF'],
                        ['telefone','Telefone'],
                        ['empresa', 'Empresa'],
                        ['veiculo', 'Veículo'],
                        ['placa', 'Placa']
                    ] as [$id, $label])
                        <div class="col-6">
                            <label for="{{ $id }}" class="form-label">{{ $label }}</label>
                            <input type="text" class="form-control rounded-pill border-dark" id="{{ $id }}" name="{{ $id }}" value="{{ old($id, $edit ? $visitante->$id : '') }}">
                        </div>
                    @endforeach

                    <div class="col-lg-6">
                        <label for="tipo_acesso" class="form-label">Tipo de Acesso</label>
                        <select class="form-select rounded-pill border-dark" name="tipo_acesso" id="tipo_acesso">
                            <option value="">Selecione...</option>
                            @foreach (['visita', 'entrega', 'mudança', 'manutenção', 'abastecimento', 'limpeza', 'dedetização'] as $tipo)
                                <option value="{{ $tipo }}" {{ old('tipo_acesso', $visitante->tipo_acesso ?? '') == $tipo ? 'selected' : '' }}>
                                    {{ ucfirst($tipo) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="observacoes" class="form-label">Observação</label>
                        <textarea class="form-control rounded-4 border-dark" name="observacoes" id="observacoes" rows="4" style="resize: none">{{ old('observacoes', $edit ? $visitante->observacoes : '') }}</textarea>
                    </div>
                </div>

            </div>

            <div class="col-lg-3">
                <div class="card h-100 shadow-sm p-3 text-center d-flex flex-column justify-content-between">
                    <label class="form-label"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-camera2" viewBox="0 0 16 16">
                        <path d="M5 8c0-1.657 2.343-3 4-3V4a4 4 0 0 0-4 4"/>
                        <path d="M12.318 3h2.015C15.253 3 16 3.746 16 4.667v6.666c0 .92-.746 1.667-1.667 1.667h-2.015A5.97 5.97 0 0 1 9 14a5.97 5.97 0 0 1-3.318-1H1.667C.747 13 0 12.254 0 11.333V4.667C0 3.747.746 3 1.667 3H2a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1h.682A5.97 5.97 0 0 1 9 2c1.227 0 2.367.368 3.318 1M2 4.5a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0M14 8A5 5 0 1 0 4 8a5 5 0 0 0 10 0"/>
                      </svg></label>
                    <div>
                        <img id="photo" src="{{ $edit && $visitante->image ? $visitante->image : Vite::asset('/resources/images/avatar2.png') }}" class="img-fluid rounded mb-3 border" alt="Foto">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-primary rounded-pill btn-sm" onclick="document.getElementById('user-image').click()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-image" viewBox="0 0 16 16">
                            <path d="M8.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                            <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v8l-2.083-2.083a.5.5 0 0 0-.76.063L8 11 5.835 9.7a.5.5 0 0 0-.611.076L3 12z"/>
                        </svg> Escolher Arquivo</button>
                        <input type="file" id="user-image" name="image" accept="image/*" class="d-none" required>
                        <button type="button" class="btn btn-outline-secondary rounded-pill btn-sm" data-bs-toggle="modal" data-bs-target="#modalCamera"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-camera" viewBox="0 0 16 16">
                            <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4z"/>
                            <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5m0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7M3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
                        </svg> Usar Câmera</button>
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex gap-2 justify-content-end mt-4">
                <button type="submit" class="btn btn-success rounded-pill">{{ $edit ? "Alterar" : "Salvar" }}</button>
                <button type="reset" class="btn btn-outline-danger rounded-pill">Limpar</button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">Cancelar</a>
            </div>
        </div>
        
        @include('components.modal-camera')
    </form>
</div>

@endsection