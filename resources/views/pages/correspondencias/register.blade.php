@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($correspondencia) ? true : false;
@endphp

@include('components.alerts')

<header class="mb-2 px-4 py-3 bg-white border rounded shadow-sm d-flex align-items-center justify-content-between">
    <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3">
        <span class="icon-container" style="width: 32px; height: 32px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path d="M2 13c0 1 1 1 1 1h5.256A4.5 4.5 0 0 1 8 12.5a4.5 4.5 0 0 1 1.544-3.393Q8.844 9.002 8 9c-5 0-6 3-6 4"/>
            </svg>
        </span>
        {{ $edit ? 'Editar Correspondência' : 'Cadastrar Correspodência' }}
    </h3>
    <div>
        <a href="{{ route('index.correspondencia') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
            </svg> Voltar
        </a>
    </div>
</header>

{{-- <header class="mb-3 px-4 py-3 bg-white border rounded shadow-sm">
    <h3 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
        📨 Nova Correspondência
    </h3>
</header> --}}

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
        <form action="{{ route('store.correspondencia') }}" method="POST" id="form-correspondencia">
            @csrf

           {{-- Morador --}}
            <div class="mb-3">
                <label for="id_morador" class="form-label">👤 Morador</label>
                <select name="id_morador" class="form-select tom-select" required>
                    <option value="">Selecione um morador...</option>
                    @foreach($moradores as $morador)
                        <option value="{{ $morador->id }}">
                            {{ $morador->nome }}
                            @if($morador->apartamento)
                                (Ap {{ $morador->apartamento->numero }}, Bl {{ $morador->apartamento->bloco }})
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tipo --}}
            <div class="mb-3">
                <label for="tipo" class="form-label">📦 Tipo</label>
                <input type="text" name="tipo" class="form-control" list="tipos" placeholder="Ex: Pacote, Carta, Caixa..." required>
                <datalist id="tipos">
                    <option value="Pacote">
                    <option value="Carta">
                    <option value="Caixa">
                    <option value="Encomenda">
                    <option value="Documentos">
                </datalist>
            </div>

            {{-- Remetente --}}
            <div class="mb-3">
                <label for="remetente" class="form-label">✉️ Remetente</label>
                <input type="text" name="remetente" class="form-control" placeholder="Nome ou empresa que enviou">
            </div>

            {{-- Observações --}}
            <div class="mb-3">
                <label for="observacoes" class="form-label">📝 Observações</label>
                <textarea name="observacoes" class="form-control" rows="3" placeholder="Ex: Deixar na portaria, frágil, etc."></textarea>
            </div>

            {{-- Data de recebimento (opcional) --}}
            <div class="mb-3">
                <label for="recebida_em" class="form-label">📅 Recebida em</label>
                <input type="datetime-local" name="recebida_em" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}">
            </div>

            {{-- Botões --}}
            <div class="col-12 d-flex gap-2 justify-content-end mt-3">
                <button type="submit" class="btn btn-success rounded-pill">{{ $edit ? "Alterar" : "Salvar" }}</button>
                <button type="reset" class="btn btn-outline-danger rounded-pill" onclick="return confirm('Tem certeza que deseja limpar o formulário?')">Limpar</button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection
