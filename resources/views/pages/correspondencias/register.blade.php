@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-3 px-4 py-3 bg-white border rounded shadow-sm">
    <h3 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
        📨 Nova Correspondência
    </h3>
</header>

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
                            {{ $morador->nome }} (Ap {{ optional($morador->apartamento)->numero }}, Bl {{ optional($morador->apartamento)->bloco }})
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
            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('index.correspondencia') }}" class="btn btn-outline-secondary rounded-pill">Cancelar</a>

                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-outline-warning rounded-pill">Limpar</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Registrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
