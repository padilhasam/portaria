@extends('layouts.dashboard')

@section('page_dashboard')

    <header class="header-content">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Agendamentos de Áreas Comuns</h3>
                <a href="{{ route('create.agendamento') }}" class="btn text-white btn-dark">Criar Agenda</a>
        </div>
    </header>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="">
        <div class="">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Área</th>
                        <th scope="col">Data</th>
                        <th scope="col">Horário</th>
                        <th scope="col">Usuário</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ações</th>
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