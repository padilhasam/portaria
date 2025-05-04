@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($morador);
@endphp

<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center gap-3">
    {{ svg('hugeicons-user-multiple') }}
    <h3 class="m-0 fw-bold text-dark">{{ $edit ? 'Alterar' : 'Cadastrar' }} Morador</h3>
</header>

<div class="container">
    <form action="{{ $edit ? route('update.morador', ['id' => $morador->id]) : route('store.morador') }}" method="POST" class="needs-validation">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        {{-- DADOS PESSOAIS --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">Dados Pessoais</div>
            <div class="card-body row g-3">
                <div class="col-md-4">
                    <label for="nome" class="form-label">Nome</label>
                    <input name="nome" type="text" class="form-control" id="nome" required
                        value="{{ old('nome', $edit ? $morador->nome : '') }}">
                </div>
                <div class="col-md-4">
                    <label for="documento" class="form-label">CPF</label>
                    <input name="documento" type="text" class="form-control" id="documento" required
                        value="{{ old('documento', $edit ? $morador->documento : '') }}"
                        onkeyup="mascara(this, mcpf)">
                        <div id="cpf-error" class="invalid-feedback d-none">CPF inválido</div>
                </div>
                <div class="col-md-4">
                    <label for="nascimento" class="form-label">Nascimento</label>
                    <input name="nascimento" type="text" class="form-control" id="nascimento" required
                        value="{{ old('nascimento', $edit ? $morador->nascimento : '') }}"
                        onkeyup="mascara(this, mdata)">
                </div>

                <div class="col-md-4">
                    <label for="tel_fixo" class="form-label">Telefone Fixo</label>
                    <input name="tel_fixo" type="text" class="form-control" id="tel_fixo" required
                        value="{{ old('tel_fixo', $edit ? $morador->tel_fixo : '') }}"
                        onkeyup="mascara(this, mfonefixo)">
                </div>
                <div class="col-md-4">
                    <label for="celular" class="form-label">Celular</label>
                    <input name="celular" type="text" class="form-control" id="celular" required
                        value="{{ old('celular', $edit ? $morador->celular : '') }}"
                        onkeyup="mascara(this, mtel)">
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">E-mail</label>
                    <input name="email" type="email" class="form-control" id="email" required
                        value="{{ old('email', $edit ? $morador->email : '') }}">
                </div>
                <div class="col-md-4">
                    <label for="tipo_morador" class="form-label">Tipo Morador</label>
                    <select name="tipo_morador" id="tipo_morador" class="form-select" required>
                        <option value="">Selecione</option>
                        <option value="aluguel" {{ old('tipo_morador', $edit ? $morador->tipo_morador : '') == "aluguel" ? "selected" : "" }}>Aluguel</option>
                        <option value="propria" {{ old('tipo_morador', $edit ? $morador->tipo_morador : '') == "propria" ? "selected" : "" }}>Própria</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- APARTAMENTO --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">Apartamento</div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="id_apartamento" class="form-label">Apartamento</label>
                    <div class="d-flex gap-2">
                        <select name="id_apartamento" id="id_apartamento" class="form-select flex-grow-1" required>
                            <option value="">Selecione</option>
                            @foreach ($apartamentos as $apartamento)
                                <option value="{{ $apartamento->id }}"
                                    {{ old('id_apartamento', $edit ? $morador->id_apartamento : '') == $apartamento->id ? 'selected' : '' }}>
                                    Apto {{ $apartamento->numero }}
                                </option>
                            @endforeach
                        </select>
                        <a href="{{ route('create.apartamento', ['from' => 'morador']) }}" class="btn btn-outline-secondary">+</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="bloco" class="form-label">Bloco</label>
                    <input type="text" name="bloco" id="bloco" class="form-control" readonly required
                        value="{{ $edit ? optional($morador->apartamento)->bloco : '' }}">
                </div>
                <div class="col-md-3">
                    <label for="ramal" class="form-label">Ramal</label>
                    <input type="text" name="ramal" id="ramal" class="form-control" readonly
                        value="{{ $edit ? optional($morador->apartamento)->ramal : '' }}">
                </div>
            </div>
        </div>

        {{-- VEÍCULO --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">Veículo</div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="id_veiculo" class="form-label">Veículo</label>
                    <div class="d-flex gap-2">
                        <select name="id_veiculo" id="id_veiculo" class="form-select flex-grow-1" required>
                            <option value="">Selecione</option>
                            @foreach ($veiculos as $veiculo)
                                <option value="{{ $veiculo->id }}"
                                    {{ old('id_veiculo', $edit ? $morador->id_veiculo : '') == $veiculo->id ? 'selected' : '' }}>
                                    {{ $veiculo->placa }} - {{ $veiculo->modelo }}
                                </option>
                            @endforeach
                        </select>
                        <a href="{{ route('create.veiculo', ['from' => 'morador']) }}" class="btn btn-outline-secondary">+</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="placa" class="form-label">Placa</label>
                    <input type="text" name="placa" id="placa" class="form-control" readonly required
                        value="{{ $edit ? optional($morador->veiculo)->placa : '' }}">
                </div>
                <div class="col-md-3">
                    <label for="vaga" class="form-label">Vaga</label>
                    <input type="text" name="vaga" id="vaga" class="form-control" readonly
                        value="{{ $edit ? optional($morador->veiculo)->vaga : '' }}">
                </div>
            </div>
        </div>

        {{-- BOTÕES --}}
        <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-danger">Limpar</button>
            <button type="submit" class="btn btn-success">{{ $edit ? "Alterar" : "Salvar" }}</button>
        </div>
    </form>
</div>

@endsection