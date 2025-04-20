@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($morador) ? true : false;
@endphp

<header class="header-content">
    <div>
        <h3>{{ $edit ? "Alterar" : "Cadastrar" }} morador</h3>
    </div>
</header>
<div class="container">
    <form action="{{ $edit ? route('update.morador', ['id' => $morador->id]) : route('store.morador') }}" method="POST">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome</label>
                <input name="nome" type="text" class="form-control" required id="nome" placeholder="" value="{{ $edit ? $morador->nome : "" }}">
            </div>
            <div class="col-md-6">
                <label for="documento" class="form-label">CPF</label>
                <input name="documento" type="text" class="form-control" required id="documento" placeholder="" value="{{ $edit ? $morador->documento : "" }}" onkeyup="mascara(this, mcpf)">
                <p id="cpf-error" class="text-danger small mt-1" style="display: none;">CPF inválido</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nascimento" class="form-label">Data de Nascimento</label>
                <input name="nascimento" type="text" class="form-control" required id="nascimento" placeholder="" value="{{ $edit ? $morador->nascimento : "" }}" onkeyup="mascara(this, mdata)">
            </div>
            <div class="col-md-6">
                <label for="tel_fixo" class="form-label">Telefone Fixo</label>
                <input name="tel_fixo" type="text" class="form-control" required id="tel_fixo" placeholder="" value="{{ $edit ? $morador->tel_fixo : "" }}" onkeyup="mascara(this, mfonefixo)">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="celular" class="form-label">Celular</label>
                <input name="celular" type="text" class="form-control" required id="celular" placeholder="" value="{{ $edit ? $morador->celular : "" }}" onkeyup="mascara(this, mtel)">
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">E-mail</label>
                <input name="email" type="text" class="form-control" required id="email" placeholder="" value="{{ $edit ? $morador->email : "" }}" onkeyup="mascara(this, memail)">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="tipo_morador" class="form-label">Tipo Morador</label>
                <select name="tipo_morador" id="tipo_morador" class="form-control" required>
                    <option value="selecione">Selecione</option>
                    <option value="aluguel" {{ $edit && $morador->tipo_morador == "aluguel" ? "selected" : "" }}>Aluguel</option>
                    <option value="propria" {{ $edit && $morador->tipo_morador == "propria" ? "selected" : "" }}>Própria</option>
                </select>
            </div>
        </div>

        <fieldset class="row mb-3 border p-3 rounded">
            <legend class="float-none w-auto p-2">Informações do Apartamento</legend>
            <div class="col-md-6">
                <label for="id_apartamento" class="form-label">Apartamento</label>
                <div class="d-flex gap-2">
                    <select name="id_apartamento" id="id_apartamento" class="form-control flex-grow-1" required>
                        <option value="">Selecione</option>
                        @foreach ($apartamentos as $apartamento)
                            <option value="{{ $apartamento->id }}" {{ $edit && $morador->id_apartamento == $apartamento->id ? "selected" : "" }}>Apartamento {{ $apartamento->numero }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('create.apartamento', ['from' => 'morador']) }}" class="btn btn-secondary" title="Adicionar novo apartamento">
                        +
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <label for="bloco" class="form-label">Bloco</label>
                <input type="text" name="bloco" id="bloco" class="form-control" value="{{ $edit ? optional($morador->apartamento)->bloco : '' }}" required readonly>
            </div>
        </fieldset>

        <fieldset class="row mb-3 border p-3 rounded">
            <legend class="float-none w-auto p-2">Informações do Veículo</legend>
            <div class="col-md-6">
                <label for="id_veiculo" class="form-label">Veículo</label>
                <div class="d-flex gap-2">
                    <select name="id_veiculo" id="id_veiculo" class="form-control flex-grow-1" required>
                        <option value="">Selecione</option>
                        @foreach ($veiculos as $veiculo)
                            <option value="{{ $veiculo->id }}" {{ $edit && $morador->id_veiculo == $veiculo->id ? 'selected' : '' }}>
                                Veículo {{ $veiculo->id }}
                            </option>
                        @endforeach
                    </select>
                    <a href="{{ route('create.veiculo', ['from' => 'morador']) }}" class="btn btn-secondary" title="Adicionar novo veículo">
                        +
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <label for="placa" class="form-label">Placa</label>
                <input type="text" name="placa" id="placa" class="form-control"
                    value="{{ $edit ? optional($morador->veiculo)->placa : '' }}" required readonly>
            </div>
        </fieldset>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">{{ $edit ? "Alterar" : "Salvar" }}</button>
            <button type="reset" class="btn btn-danger">Limpar</button>
        </div>
    </form>
</div>

@vite([
    'resources/js/mascara.js',
    'resources/js/validarCPF.js',
    'resources/js/preencherCampos.js',
    'resources/js/tom-select-init.js'
])

@endsection