@extends('layouts.dashboard')

@section('page_dashboard')

<header class="header-content">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Agendamentos de Áreas Comuns</h3>
    </div>
</header>

<div class="container">

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-6 shadow">
            <ul class="list-disc pl-5 space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('store.agendamento') }}" method="POST" class="bg-white p-10 rounded-2xl shadow-xl space-y-8">
        @csrf

            <div class="form-group">
                <label for="area">Área Comum</label>
                <input type="text" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="area" id="area" value="{{ old('area') }}" required>
            </div>
            <div class="form-group">
                <label for="data">Data do Agendamento</label>
                <input type="date" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="data" id="data" value="{{ old('data') }}" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="hora_inicio">Horário de Início</label>
                    <input type="time" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}" required>
                </div>

                <div>
                    <label for="hora_fim">Horário de Término</label>
                    <input type="time" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="hora_fim" id="hora_fim" value="{{ old('hora_fim') }}" required>
                </div>
            </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-dark">Confirmar Agendamento</button>
        </div>
        <div class="mt-4">
            <a href="{{ route('index.agendamento') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
                ← Voltar para Agendamentos
            </a>
        </div>
    </form>
</div>

@endsection