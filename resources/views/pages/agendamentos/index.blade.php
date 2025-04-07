@extends('layouts.app')

@section('page_dashboard')

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Agendamentos de Áreas Comuns</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('create.agendamento') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-300">
            Novo Agendamento
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-left table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4">Área</th>
                    <th class="p-4">Data</th>
                    <th class="p-4">Horário</th>
                    <th class="p-4">Usuário</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agendamentos as $agendamento)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-4">{{ $agendamento->area }}</td>
                        <td class="p-4">{{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y') }}</td>
                        <td class="p-4">{{ $agendamento->hora_inicio }} - {{ $agendamento->hora_fim }}</td>
                        <td class="p-4">{{ $agendamento->usuario->name ?? 'N/A' }}</td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded text-sm {{ $agendamento->status === 'aprovado' ? 'bg-green-200 text-green-800' : ($agendamento->status === 'recusado' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800') }}">
                                {{ ucfirst($agendamento->status) }}
                            </span>
                        </td>
                        <td class="p-4 flex space-x-2">
                            <a href="{{ route('edit.agendamento', $agendamento->id) }}" class="text-indigo-600 hover:underline">Editar</a>
                            <form action="{{ route('destroy.agendamento', $agendamento->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este agendamento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">Nenhum agendamento encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection