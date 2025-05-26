@extends('layouts.dashboard')

@section('page_dashboard')

<header class="header-content">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Relatório de Atividades</h3>
        <a href="#" class="btn text-white btn-dark">RELATÒRIOS</a>
    </div>
</header>

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Gerar Relatório de Acessos</h1>

    <form action="#" method="GET" class="space-y-4 max-w-lg">{{-- {{ route('relatorios.acessos') }} --}}
        <div>
            <label for="data_inicio" class="block font-medium mb-1">Data Início</label>
            <input
                type="date"
                id="data_inicio"
                name="data_inicio"
                value="{{ old('data_inicio', request('data_inicio')) }}"
                class="w-full border rounded px-3 py-2"
                required
            >
        </div>

        <div>
            <label for="data_fim" class="block font-medium mb-1">Data Fim</label>
            <input
                type="date"
                id="data_fim"
                name="data_fim"
                value="{{ old('data_fim', request('data_fim')) }}"
                class="w-full border rounded px-3 py-2"
                required
            >
        </div>

        <button
            type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition"
        >
            Gerar Relatório
        </button>
    </form>
</div>

@endsection