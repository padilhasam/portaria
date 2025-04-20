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

@if (session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6 shadow">
        {{ session('success') }}
    </div>
@endif

<header class="header-content">
    <div>
        <h3>{{ $edit ? "Alterar Apartamento" : "Cadastrar Apartamento" }}</h3>
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
            <input name="numero" type="text" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" id="numero" placeholder="Ex: 101" value="{{ old('numero', $edit ? $apartamento->numero : '') }}" required autofocus>
        </div>
        <div class="form-group">
            <label for="bloco">Bloco</label>
            <input name="bloco" type="text" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" id="bloco" placeholder="Bloco A" value="{{ old('bloco', $edit ? $apartamento->bloco : '')}}" required>
        </div>
        <div class="form-group">
            <label for="vaga">Número da Vaga</label>
            <input name="vaga" type="text" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" id="vaga" placeholder="Ex: 01 ou 01A" value="{{ old('vaga', $edit ? $apartamento->vaga : '' )}}" required>
        </div>
        <div class="form-group">
            <label for="ramal">Ramal</label>
            <input name="ramal" type="text" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" id="ramal" placeholder="Ex: 205" value="{{ old('ramal', $edit ? $apartamento->ramal : '')}}" required>
        </div>
        <div class="form-group">
            <label for="status_vaga">Status da vaga</label>
            <select class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="status_vaga" id="status_vaga">
                <option value="">Selecione</option>
                <option value="livre" {{ $edit && $apartamento->status_vaga == "livre" ? "selected" : "" }}>Livre</option>
                <option value="ocupada" {{ $edit && $apartamento->status_vaga == "ocupada" ? "selected" : "" }}>Ocupada</option>
                <option value="emprestada" {{ $edit && $apartamento->status_vaga == "emprestada" ? "selected" : "" }}>Emprestada</option>
                <option value="alugada" {{ $edit && $apartamento->status_vaga == "alugada" ? "selected" : "" }}>Alugada</option>
            </select>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label for="observacoes">Observações</label>
                <textarea class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="observacoes" id="observacoes" rows="4" cols="50" style="resize: none">{{ old('observacoes') }}</textarea>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-success">{{ $edit ? "Alterar Apartamento" : "Salvar" }}</button>
            <button type="reset" class="btn btn-danger">Limpar</button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
    @if (session('success'))
        <script>
            setTimeout(function() {
                const successMessage = document.querySelector('.bg-green-100');
                if (successMessage) {
                    successMessage.remove();
                }
            }, 3000); // Remove a mensagem após 3 segundos
        </script>
    @endif
@endsection