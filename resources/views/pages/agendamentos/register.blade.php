@extends('layouts.app')

@section('page_dashboard')

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Novo Agendamento</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('store.agendamento') }}" method="POST" class="bg-white p-6 rounded shadow-md space-y-6">
        @csrf

        <div>
            <label for="area" class="block text-sm font-medium text-gray-700">Área</label>
            <input type="text" name="area" id="area" value="{{ old('area') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div>
            <label for="data" class="block text-sm font-medium text-gray-700">Data</label>
            <input type="date" name="data" id="data" value="{{ old('data') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Hora Início</label>
                <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="hora_fim" class="block text-sm font-medium text-gray-700">Hora Fim</label>
                <input type="time" name="hora_fim" id="hora_fim" value="{{ old('hora_fim') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('index.agendamento') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded mr-4">Cancelar</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded">Agendar</button>
        </div>
    </form>
</div>
@endsection