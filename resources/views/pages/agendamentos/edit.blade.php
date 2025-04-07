@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Editar Agendamento</h1>

    {{-- Mensagem de erro de validação --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulário de edição --}}
    <form action="{{ route('update.agendamento', $agendamento->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700">Nome da Área</label>
            <input type="text" name="nome_area" value="{{ old('nome_area', $agendamento->nome_area) }}" required
                class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-gray-700">Data do Agendamento</label>
            <input type="date" name="data_agendamento" value="{{ old('data_agendamento', $agendamento->data_agendamento) }}" required
                class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-gray-700">Horário de Início</label>
            <input type="time" name="horario_inicio" value="{{ old('horario_inicio', $agendamento->horario_inicio) }}" required
                class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-gray-700">Horário de Fim</label>
            <input type="time" name="horario_fim" value="{{ old('horario_fim', $agendamento->horario_fim) }}" required
                class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-gray-700">Observações</label>
            <textarea name="observacoes" rows="4" class="w-full border rounded p-2">{{ old('observacoes', $agendamento->observacoes) }}</textarea>
        </div>

        <div class="flex justify-between">
            <a href="{{ route('pages.agendamento.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar Alterações</button>
        </div>
    </form>
</div>
@endsection