@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($apartamento) ? true : false;
@endphp

@if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-6 shadow">
            <ul class="list-disc pl-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<header class="header-content">
    <div>
        <h3>{{ $edit ? "Alterar" : "Cadastrar" }} apartamento</h3>
    </div>
</header>
<div class="container">
    <form action="{{ $edit ? route('update.apartamento', ['id' => $apartamento->id, 'from' => request()->query('from')]) : route('store.apartamento', ['from' => request()->query('from')]) }}" method="POST">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="numero">Número Apartamento</label>
            <input name="numero" type="text" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" id="numero" placeholder="Número do apartamento" value="{{ old('numero', $edit ? $apartamento->numero : '') }}" required>
        </div>
        <div class="form-group">
            <label for="bloco">Bloco</label>
            <input name="bloco" type="text" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" id="bloco" placeholder="Digite o bloco do apartamento" value="{{ old('bloco', $edit ? $apartamento->bloco : '')}}" required>
        </div>
        <div class="form-group">
            <label for="vaga">Número da Vagas</label>
            <input name="vaga" type="text" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" id="vaga" placeholder="Vagas" value="{{ old('vaga', $edit ? $apartamento->vaga : '' )}}" required>
        </div>
        <div class="form-group">
            <label for="ramal">Ramal</label>
            <input name="ramal" type="text" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" id="ramal" placeholder="Ramal" value="{{ old('ramal', $edit ? $apartamento->ramal : '')}}" required>
        </div>
        <div class="form-group">
            <label for="status_vaga">Status da vaga</label>
            <select class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="status_vaga" id="status_vaga">
                <option value="Selecione">Selecione</option>
                <option value="livre" {{ $edit && $apartamento->status_vaga == "livre" ? "selected" : "" }}>Livre</option>
                <option value="ocupada" {{ $edit && $apartamento->status_vaga == "ocupada" ? "selected" : "" }}>Ocupada</option>
                <option value="emprestada" {{ $edit && $apartamento->status_vaga == "emprestada" ? "selected" : "" }}>Emprestada</option>
                <option value="alugada" {{ $edit && $apartamento->status_vaga == "alugada" ? "selected" : "" }}>Alugada</option>
            </select>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-dark">{{ $edit ? "Alterar" : "Salvar" }}</button>
            <button type="reset" class="btn btn-dark">Limpar</button>
        </div>
    </form>
</div>

@endsection