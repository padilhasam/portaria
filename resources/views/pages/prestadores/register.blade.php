@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($prestador) ? true : false;
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
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-wrench-adjustable-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8a8 8 0 1 1-15.999-.001A8 8 0 0 1 16 8M6.504 1.869a.5.5 0 0 0-.678.21l-.755 1.51a.5.5 0 0 0 .182.657l1.321.88a.5.5 0 0 1-.183.906l-.933.2a.5.5 0 0 0-.397.609l.293 1.177a.5.5 0 0 1-.597.598l-1.176-.293a.5.5 0 0 0-.61.397l-.2.933a.5.5 0 0 1-.905.183l-.88-1.322a.5.5 0 0 0-.658-.182l-1.51.756a.5.5 0 0 0-.21.678l1.5 3.001a.5.5 0 0 0 .672.224l1.643-.863A.5.5 0 0 1 4 10.5v-.82a.5.5 0 0 1 .5-.5h.82a.5.5 0 0 1 .447.276l.416.831a.5.5 0 0 0 .671.224l3.001-1.5a.5.5 0 0 0 .21-.678z"/>
            </svg>
        </span>
        {{ $edit ? 'Editar Serviço' : 'Cadastrar Serviço' }}
    </h3>
    <div>
        <a href="{{ route('index.prestador') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg> Voltar
        </a>
    </div>
</header>

<div class="card shadow-sm p-2">
    <form method="POST" action="{{ $edit ? route('update.prestador', ['id' => $prestador->id]) : route('store.prestador') }}" class="needs-validation">
        @csrf
        @if($edit)
            @method('PUT')
        @endif

        {{-- DADOS DA EMPRESA --}}
        <div class="card shadow-sm mb-2">
            <div class="card-header bg-light fw-bold">Dados da Empresa</div>
                <div class="card-body row g-3">

                {{-- Empresa Prestadora --}}
                <div class="col-md-6">
                    <label for="empresa" class="form-label">Razão Social</label>
                    <input type="text" name="empresa" class="form-control rounded-pill border-dark" id="empresa" value="{{ old('empresa', $edit ? $prestador->empresa : '') }}" required>
                </div>

                {{-- CNPJ --}}
                <div class="col-md-3">
                    <label for="cnpj" class="form-label">CNPJ</label>
                    <input type="text" name="cnpj" class="form-control rounded-pill border-dark" value="{{ old('cnpj', $edit ? $prestador->cnpj : '') }}" required>
                </div>
                
                <div class="col-md-3">
                    <label for="tel_fixo" class="form-label">Telefone Fixo</label>
                    <input name="tel_fixo" type="text" class="form-control rounded-pill border-dark" id="tel_fixo" required
                    value="{{ old('tel_fixo', $edit ? $prestador->tel_fixo : '') }}">
                </div>

                <div class="col-md-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input name="email" type="email" class="form-control rounded-pill border-dark" id="email" required
                        value="{{ old('email', $edit ? $prestador->email : '') }}">
                </div>

                {{-- Nome da Pessoa que Prestará o Serviço --}}
                <div class="col-md-3">
                    <label for="prestador" class="form-label">Nome do Prestador</label>
                    <input type="text" name="prestador" class="form-control rounded-pill border-dark"
                    value="{{ old('prestador', $edit ? $prestador->prestador : '') }}" required>
                </div>

                {{-- Nome da Pessoa que Prestará o Serviço --}}
                <div class="col-md-3">
                    <label for="documento" class="form-label">CPF</label>
                    <input name="documento" type="text" class="form-control rounded-pill border-dark" id="documento" required
                        value="{{ old('documento', $edit ? $prestador->documento : '') }}"
                        >
                    <div id="cpf-error" class="invalid-feedback d-none">CPF inválido</div>
            </div>


            <div class="col-md-3">
                <label for="celular" class="form-label">Celular</label>
                <input name="celular" type="text" class="form-control rounded-pill border-dark" id="celular" required
                value="{{ old('celular', $edit ? $prestador->celular : '') }}">
            </div>

            {{-- Acompanhantes --}}
            <div class="col-md-3">
                <label for="acompanhante" class="form-label">Acompanhante</label>
                <input type="text" name="acompanhante" class="form-control rounded-pill border-dark" value="{{ old('acompanhante', $edit ? $prestador->acompanhante : '') }}">
            </div>

            <div class="col-9">
                <label for="observacoes" class="form-label">Observação</label>
                <textarea class="form-control rounded-4 border-dark" name="observacoes" id="observacoes" rows="2" style="resize: none">{{ old('observacoes', $edit ? $prestador->observacoes : '') }}</textarea>
            </div>

            </div>
        </div>

        {{-- VEÍCULO --}}
        <div class="card shadow-sm mb-2">
            <div class="card-header bg-light fw-bold">
                <div class="w-100 d-flex justify-content-between">
                    Veículo
                    <a href="{{ route('create.veiculo', ['from' => 'prestadores']) }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="card-body row g-3">
                <div class="col-md-3">
                    <label for="id_veiculo" class="form-label">Placa</label>
                    <div class="d-flex gap-2">
                        <select name="id_veiculo" id="id_veiculo" class="form-select rounded-pill border-dark" required>
                            <option value="">Selecione</option>
                            @foreach ($veiculos as $veiculo)
                                <option value="{{ $veiculo->id }}"
                                    {{ old('id_veiculo', $edit ? $prestador->id_veiculo : '') == $veiculo->id ? 'selected' : '' }}>
                                    {{ $veiculo->placa }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="modelo" class="form-label">Modelo</label>
                    <input type="text" name="modelo" id="modelo" class="form-control rounded-pill border-dark" readonly required
                        value="{{ $edit ? optional($prestador->veiculo)->modelo : '' }}">
                </div>
                <div class="col-md-3">
                    <label for="marca" class="form-label">Marca</label>
                    <input type="text" name="marca" id="marca" class="form-control rounded-pill border-dark" readonly required
                        value="{{ $edit ? optional($prestador->veiculo)->marca : '' }}">
                </div>
                <div class="col-md-3">
                    <label for="cor" class="form-label">Cor</label>
                    <input type="text" name="cor" id="cor" class="form-control rounded-pill border-dark" readonly required
                        value="{{ $edit ? optional($prestador->veiculo)->cor : '' }}">
                </div>
            </div>
        </div>

        {{-- BOTÕES --}}
        <div class="col-12 d-flex gap-2 justify-content-end mt-3">
            <button type="submit" class="btn btn-success rounded-pill">{{ $edit ? "Alterar" : "Salvar" }}</button>
            <button type="reset" class="btn btn-outline-danger rounded-pill" onclick="return confirm('Tem certeza que deseja limpar o formulário?')">Limpar</button>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">Cancelar</a>
        </div>

    </form>
</div>

@endsection