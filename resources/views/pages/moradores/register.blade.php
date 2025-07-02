@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($morador)? true : false;
@endphp

@include('components.alerts')

<header class="mb-2 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container" style="width: 32px; height: 32px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
            </svg>
        </span>
        {{ $edit ? 'Editar Morador' : 'Cadastrar Morador' }}
    </h3>
    <div>
        <a href="{{ route('index.morador') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg> Voltar
        </a>
    </div>
</header>

<div class="card shadow-sm p-2">
    <form action="{{ $edit ? route('update.morador', ['id' => $morador->id]) : route('store.morador') }}" method="POST" class="needs-validation">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        {{-- DADOS PESSOAIS --}}
        <div class="card shadow-sm mb-2">
            <div class="card-header bg-light fw-bold">Dados Pessoais</div>
            <div class="card-body row g-3">
                 <div class="col-md-4">
                    <label for="nome" class="form-label fw-semibold">Nome <span class="text-danger">*</span></label>
                    <input name="nome" type="text" class="form-control rounded-pill border-dark @error('nome') is-invalid @enderror" id="nome" placeholder="Nome Completo" required
                        value="{{ old('nome', $edit ? $morador->nome : '') }}">
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="documento" class="form-label fw-semibold">CPF <span class="text-danger">*</span></label>
                    <input name="documento" type="text" class="form-control rounded-pill border-dark @error('documento') is-invalid @enderror" id="documento" placeholder="CPF" required
                        value="{{ old('documento', $edit ? $morador->documento : '') }}">
                    <div id="cpf-error" class="invalid-feedback d-none">CPF inválido</div>
                    @error('documento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="nascimento" class="form-label fw-semibold">Nascimento <span class="text-danger">*</span></label>
                    <input name="nascimento" type="date" class="form-control rounded-pill border-dark @error('nascimento') is-invalid @enderror" id="nascimento" required
                        value="{{ old('nascimento', $edit ? $morador->nascimento : '') }}">
                    @error('nascimento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="tel_fixo" class="form-label fw-semibold">Telefone Fixo <span class="text-danger">*</span></label>
                    <input name="tel_fixo" type="text" class="form-control rounded-pill border-dark @error('tel_fixo') is-invalid @enderror" id="tel_fixo" placeholder="Telefone Fixo" required
                        value="{{ old('tel_fixo', $edit ? $morador->tel_fixo : '') }}">
                    @error('tel_fixo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="celular" class="form-label fw-semibold">Celular <span class="text-danger">*</span></label>
                    <input name="celular" type="text" class="form-control rounded-pill border-dark @error('celular') is-invalid @enderror" id="celular" placeholder="Whatsapp" required
                        value="{{ old('celular', $edit ? $morador->celular : '') }}">
                    @error('celular')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label fw-semibold">E-mail <span class="text-danger">*</span></label>
                    <input name="email" type="email" class="form-control rounded-pill border-dark @error('email') is-invalid @enderror" id="email" placeholder="E-mail" required
                        value="{{ old('email', $edit ? $morador->email : '') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="tipo_morador" class="form-label fw-semibold">Tipo Morador <span class="text-danger">*</span></label>
                    <select name="tipo_morador" id="tipo_morador" class="form-select rounded-pill border-dark @error('tipo_morador') is-invalid @enderror" required>
                        <option value="">Selecione o tipo de morador...</option>
                        <option value="aluguel" {{ old('tipo_morador', $edit ? $morador->tipo_morador : '') == "aluguel" ? "selected" : "" }}>Aluguel</option>
                        <option value="propria" {{ old('tipo_morador', $edit ? $morador->tipo_morador : '') == "propria" ? "selected" : "" }}>Própria</option>
                    </select>
                    @error('tipo_morador')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- APARTAMENTO --}}
        <div class="card shadow-sm mb-2">
            <div class="card-header bg-light fw-bold">
                <div class="w-100 d-flex justify-content-between">
                    Apartamento
                    <a href="{{ route('create.apartamento', ['from' => 'morador']) }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="card-body row g-3">
                <div class="col-md-3">
                    <label for="id_apartamento" class="form-label fw-semibold">Apartamento <span class="text-danger">*</span></label>
                    <select name="id_apartamento" id="id_apartamento" class="form-select rounded-pill border-dark @error('id_apartamento') is-invalid @enderror" required>
                        <option value="">Selecione o apartamento...</option>
                        @foreach ($apartamentos as $apartamento)
                            <option value="{{ $apartamento->id }}"
                                {{ old('id_apartamento', $edit ? $morador->id_apartamento : '') == $apartamento->id ? 'selected' : '' }}>
                                Apto {{ $apartamento->numero }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_apartamento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="bloco" class="form-label fw-semibold">Bloco</label>
                    <input type="text" name="bloco" id="bloco" class="form-control rounded-pill border-dark" placeholder="Bloco" readonly
                        value="{{ $edit ? optional($morador->apartamento)->bloco : '' }}">
                </div>
                <div class="col-md-3">
                    <label for="ramal" class="form-label fw-semibold">Ramal</label>
                    <input type="text" name="ramal" id="ramal" class="form-control rounded-pill border-dark" placeholder="Ramal" readonly
                        value="{{ $edit ? optional($morador->apartamento)->ramal : '' }}">
                </div>
                <div class="col-md-3">
                    <label for="vaga" class="form-label fw-semibold">Vaga</label>
                    <input type="text" name="vaga" id="vaga" class="form-control rounded-pill border-dark" placeholder="Vaga" readonly
                        value="{{ $edit ? optional($morador->apartamento)->vaga : '' }}">
                </div>
            </div>
        </div>

        {{-- VEÍCULO --}}
        <div class="card shadow-sm mb-2">
            <div class="card-header bg-light fw-bold">
                <div class="w-100 d-flex justify-content-between">
                    Veículo
                    <a href="{{ route('create.veiculo', ['from' => 'visitante']) }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="card-body row g-3">
                <div class="col-md-3">
                    <label for="id_veiculo" class="form-label fw-semibold">Placa <span class="text-danger">*</span></label>
                    <select name="id_veiculo" id="id_veiculo" class="form-select rounded-pill border-dark @error('id_veiculo') is-invalid @enderror" required>
                        <option value="">Selecione a placa do veículo...</option>
                        @foreach ($veiculos as $veiculo)
                            <option value="{{ $veiculo->id }}"
                                {{ old('id_veiculo', $edit ? $morador->id_veiculo : '') == $veiculo->id ? 'selected' : '' }}>
                                {{ $veiculo->placa }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_veiculo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="modelo" class="form-label fw-semibold">Modelo</label>
                    <input type="text" name="modelo" id="modelo" class="form-control rounded-pill border-dark" placeholder="Modelo do veículo" readonly
                        value="{{ $edit ? optional($morador->veiculo)->modelo : '' }}">
                </div>
                <div class="col-md-3">
                    <label for="marca" class="form-label fw-semibold">Marca</label>
                    <input type="text" name="marca" id="marca" class="form-control rounded-pill border-dark" placeholder="Marca do veículo" readonly
                        value="{{ $edit ? optional($morador->veiculo)->marca : '' }}">
                </div>
                <div class="col-md-3">
                    <label for="cor" class="form-label fw-semibold">Cor</label>
                    <input type="text" name="cor" id="cor" class="form-control rounded-pill border-dark" placeholder="Cor do veículo" readonly
                        value="{{ $edit ? optional($morador->veiculo)->cor : '' }}">
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
