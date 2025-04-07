@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($registro) ? true : false;
@endphp

<header class="header-content mb-4">
    <h3 class="fw-bold">{{ $edit ? "Encerrar" : "Liberar" }} Acessos</h3>
</header>

<div class="container">
    <div class="card shadow-sm p-4">
        <form action="{{ $edit ? route('update.registro', ['id' => $registro->id]) : route('store.registro') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($edit)
                @method('PUT')
            @endif

            <div class="row g-4">
                <div class="col-lg-9">
                    <div class="row g-3">
                        @foreach ([
                            ['nome', 'Nome'],
                            ['documento', 'RG ou CNPJ'],
                            ['empresa', 'Empresa'],
                            ['veiculo', 'Veículo'],
                            ['placa', 'Placa']
                        ] as [$id, $label])
                            <div class="col-md-6">
                                <label for="{{ $id }}" class="form-label">{{ $label }}</label>
                                <input type="text" class="form-control" id="{{ $id }}" name="{{ $id }}" value="{{ old($id, $registro->$id ?? '') }}" placeholder="{{ $id == 'placa' ? 'Ex: ABC1D23' : '' }}">
                            </div>
                        @endforeach

                        <div class="col-12">
                            <label for="tipo_morador" class="form-label">Tipo de Acesso</label>
                            <select class="form-select" name="tipo_morador" id="tipo_morador">
                                <option value="">Selecione...</option>
                                @foreach (['visita', 'entrega', 'mudança', 'manutenção', 'abastecimento', 'limpeza', 'dedetização'] as $tipo)
                                    <option value="{{ $tipo }}" {{ old('tipo_morador', $registro->tipo_morador ?? '') == $tipo ? 'selected' : '' }}>
                                        {{ ucfirst($tipo) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="observacao" class="form-label">Observação</label>
                            <input type="text" class="form-control" id="observacao" name="observacao" value="{{ old('observacao', $registro->observacao ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card shadow-sm p-3 text-center">
                        <label class="form-label">Foto</label>
                        <img id="photo" src="{{ isset($registro) && $registro->img ? asset('storage/' . $registro->img) : Vite::asset('/resources/images/avatar.png') }}" class="img-fluid rounded mb-3" alt="Foto">
                        
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-dark" onclick="$('#user-image').click()">Escolher Arquivo</button>
                            <input type="file" id="user-image" name="img" accept="image/*" class="d-none">
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalCamera">Usar Câmera</button>
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex gap-2 justify-content-end mt-4">
                    <button type="submit" class="btn btn-dark">{{ $edit ? "Alterar" : "Cadastrar" }}</button>
                    <button type="reset" class="btn btn-outline-secondary">Limpar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('components.modal-camera')

<!-- Carrega a biblioteca Inputmask -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/inputmask.min.js"></script>

<!-- Aplica a máscara no campo PLACA -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const placaInput = document.getElementById('placa');

    if (placaInput) {
        Inputmask({
            mask: "[AAA9A99]",
            definitions: {
                'A': {
                    validator: "[A-Za-z]",
                    casing: "upper" // Letras maiúsculas automáticas
                },
                '9': {
                    validator: "[0-9]",
                }
            },
            autoUnmask: true,
            removeMaskOnSubmit: false
        }).mask(placaInput);
    }
});
</script>

@endsection