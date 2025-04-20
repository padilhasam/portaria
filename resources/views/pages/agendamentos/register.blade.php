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
                <label for="moradores">Morador</label>
                <select name="moradores" id="moradores" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" required>
                    <option value="">Selecione</option>
                    @foreach($moradores as $morador)
                        <option value="{{ $morador->nome }}"
                            {{ old('moradores') == $morador->nome ? 'selected' : '' }}>
                            {{ $morador->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="nome_area">Área Comum</label>
                <select class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="nome_area" id="nome_area" required>{{ old('nome_area') }}
                    <option value="selecione">Selecione</option>
                    <option value="churrasqueira">Churrasqueira</option>
                    <option value="quadra">Quadra</option>
                    <option value="piscina">Piscina</option>
                    <option value="academia">Academia</option>
                </select>
            </div>
            <div class="form-group">
                <label for="data_agendamento">Data do Agendamento</label>
                <input type="date" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="data_agendamento" id="data_agendamento" value="{{ old('data_agendamento') }}" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="horario_inicio">Horário de Início</label>
                    <input type="time" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="horario_inicio" id="hora_inicio" min="08:00" max="22:00" value="{{ old('hora_inicio') }}" required>
                </div>

                <div>
                    <label for="horario_fim">Horário de Término</label>
                    <input type="time" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="horario_fim" id="hora_fim" min="08:00" max="22:00" value="{{ old('hora_fim') }}" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label for="observacoes">Observações</label>
                    <textarea class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="observacoes" id="observacoes" rows="4" cols="50" style="resize: none">{{ old('observacoes') }}</textarea>
                </div>
            </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Confirmar Agendamento</button>
        </div>
        <div class="mt-4">
            <a href="{{ route('index.agendamento') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">
                ← Voltar para Agendamentos
            </a>
        </div>
    </form>
</div>

@endsection