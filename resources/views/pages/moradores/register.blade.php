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

        <div class="form-group">
            <label for="nome">Nome</label>
            <input name="nome" type="text" class="form-control" id="nome" placeholder="" value="{{ $edit ? $morador->nome : "" }}">
        </div>
        <div class="form-group">
            <label for="documento">RG ou CPF</label>
            <input name="documento" type="text" class="form-control" id="documento" placeholder="" value="{{ $edit ? $morador->documento : "" }}">
        </div>
        <div class="form-group">
            <label for="birthdate">Data de Nascimento</label>
            <input name="birthdate" type="text" class="form-control" id="birthdate" placeholder="" value="{{ $edit ? $morador->birthdate : "" }}">
        </div>
        <div class="form-group">
            <label for="tel_fixo">Telefone Fixo</label>
            <input name="tel_fixo" type="text" class="form-control" id="tel_fixo" placeholder="" value="{{ $edit ? $morador->tel_fixo : "" }}">
        </div>
        <div class="form-group">
            <label for="celular">Celular</label>
            <input name="celular" type="text" class="form-control" id="celular" placeholder="" value="{{ $edit ? $morador->celular : "" }}">
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input name="email" type="text" class="form-control" id="email" placeholder="" value="{{ $edit ? $morador->email : "" }}">
        </div>
        <div class="form-group">
            <label for="tipo_morador">Tipo Morador</label>
            <select class="form-control" name="tipo_morador" id="tipo_morador">
                <option value="aluguel" {{ $edit && $morador->tipo_morador == "aluguel" ? "selected" : "" }}>Aluguel</option>
                <option value="propria" {{ $edit && $morador->tipo_morador == "propria" ? "selected" : "" }}>Própria</option>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Imagem</label>
            <input name="image" type="text" class="form-control" id="image" placeholder="" value="{{ $edit ? $morador->image : "" }}">
        </div>
        <div class="form-group">
            <label for="id_apartamento">Apartamentos</label>
            {{-- Busca os apartamentos da tabela apartamentos --}}
            <select class="form-control" name="id_apartamento" id="id_apartamento">
                <option value=""> Selecione... </option>    
                @foreach ($apartamentos as $apartamento)
                    <option value="{{ $apartamento->id }}"> Apartamento {{ $apartamento->id }} - Bloco {{ $apartamento->bloco }} </option>    
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">{{ $edit ? "Alterar" : "Cadastrar" }}</button>
            <button type="reset" class="btn btn-primary">Limpar</button>
        </div>
    </form>
</div>

@endsection