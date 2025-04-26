@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($registro) ? true : false;
@endphp

@if(session('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
@endif

@if(session('error'))
    <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
@endif

@if($errors->any())
    <div id="validation-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
@endif

<header class="header-content mb-4">
    <h3 class="fw-bold text-dark">{{ $edit ? "Encerrar" : "Liberar" }} Acessos</h3>
</header>

<div class="container">
    <div class="card shadow-sm p-4">
        <form action="{{ $edit ? route('update.registro', ['id' => $registro->id]) : route('store.registro') }}" method="POST" enctype="multipart/form-data" id="registroForm">
            @csrf
            @if ($edit)
                @method('PUT')
            @endif

            <div class="row g-4">
                <div class="col-lg-9">
                    <div class="row g-3">
                        @foreach ([
                            ['nome', 'Nome'],
                            ['documento', 'CPF'],
                            ['empresa', 'Empresa'],
                            ['veiculo', 'Veículo'],
                            ['placa', 'Placa']
                        ] as [$id, $label])
                            <div class="col-6">
                                <label for="{{ $id }}" class="form-label">{{ $label }}</label>
                                <input type="text" class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" id="{{ $id }}" name="{{ $id }}" value="{{ old($id, $edit ? $registro->$id : '') }}">
                            </div>
                        @endforeach

                        <div class="col-lg-6">
                            <label for="tipo_acesso" class="form-label">Tipo de Acesso</label>
                            <select class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="tipo_acesso" id="tipo_acesso">
                                <option value="">Selecione...</option>
                                @foreach (['visita', 'entrega', 'mudança', 'manutenção', 'abastecimento', 'limpeza', 'dedetização'] as $tipo)
                                    <option value="{{ $tipo }}" {{ old('tipo_acesso', $registro->tipo_acesso ?? '') == $tipo ? 'selected' : '' }}>
                                        {{ ucfirst($tipo) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-12">
                            <label for="observacoes" class="form-label">Observação</label>
                            <textarea class="form-control w-full border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" name="observacoes" id="observacoes" rows="4" style="resize: none">{{ old('observacoes', $edit ? $registro->observacoes : '') }}</textarea>
                        </div>
                    </div>

                </div>

                <div class="col-lg-3">
                    <div class="card shadow-sm p-3 text-center">
                        <label class="form-label">Foto</label>
                        <img id="photo" src="{{ $edit && $registro->foto ? $registro->foto : Vite::asset('/resources/images/avatar.png') }}" class="img-fluid rounded mb-3" alt="Foto">

                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('user-image').click()">Escolher Arquivo</button>
                            <input type="file" id="user-image" name="img" accept="image/*" class="d-none" onchange="previewImage(this)">
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalCamera">Usar Câmera</button>
                        </div>
                    </div>
                </div>

                <div class="col-12 d-flex gap-2 justify-content-end mt-4">
                    <button type="submit" class="btn btn-success">{{ $edit ? "Alterar" : "Salvar" }}</button>
                    <button type="reset" class="btn btn-danger">Limpar</button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('components.modal-camera')

<script>
   document.addEventListener('DOMContentLoaded', function () {
    const userImageInput = document.getElementById('user-image');
    const photoPreview = document.getElementById('photo');

    if (userImageInput && photoPreview) {
        userImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    photoPreview.src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});
</script>

@endsection