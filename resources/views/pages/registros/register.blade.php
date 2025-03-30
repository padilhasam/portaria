@extends('layouts.dashboard')

@section('page_dashboard')

@php
    $edit = isset($registro) ? true : false;
@endphp

<header class="header-content">
    <div>
        <h3>{{ $edit ? "Encerrar" : "Liberar" }} Acessos</h3>
    </div>
</header>
<div class="container">
    <form action="{{ $edit ? route('update.registro', ['id' => $registro->id]) : route('store.registro') }}" method="POST">
        @csrf
        @if ($edit)
            @method('PUT')
        @endif

        <div class="row">
            <div id="container1" class="row">
                <div class="col-sm-8 col-lg-10">
                    <div class="form-group col-12">
                        <label for="nome">Nome</label>
                        <input name="nome" type="text" class="form-control" id="nome" placeholder="" value="">
                    </div>
                    <div class="form-group col-12">
                        <label for="documento">RG ou CNPJ</label>
                        <input name="documento" type="text" class="form-control" id="documento" placeholder="" value="">
                        
                    </div>
                    <div class="form-group col-12">
                        <label for="empresa">Empresa</label>
                        <input name="empresa" type="text" class="form-control" id="empresa" placeholder="" value="">
                    </div>
                    <div class="form-group col-12">
                        <label for="veiculo">Veículo</label>
                        <input name="veiculo" type="text" class="form-control" id="veiculo" placeholder="" value="">
                    </div>
                    <div class="form-group col-12">
                        <label for="placa">Placa</label>
                        <input name="placa" type="text" class="form-control" id="placa" placeholder="" value="">
                    </div>
                </div>
                <div class="form-group col-sm-4 col-lg-2">
                    <label for="documento">Foto</label>
                    <img id="photo" src="{{Vite::asset('/resources/images/avatar.png')}}" class="w-100">
                    <div class="d-flex gap-2 mt-3">
                        <div>
                            <button type="button" class="btn btn-primary w-100" onclick="$('#user-image').click()">Arquivo</button>
                            <input type="file" id="user-image" name="img" accept="image/*" class="d-none">
                        </div>
                        <button type="button" id="switchFrontBtn" class="btn btn-primary w-100" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCamera">Camera</button>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="tipo_morador">Tipo de Acesso</label>
                <select class="form-control" name="tipo_morador" id="tipo_morador">
                    <option value="">Selecione...</option>
                    <option value="visita">Visita</option>
                    <option value="entrega">Entrega</option>
                    <option value="mudança">Mudança</option>
                    <option value="manutenção" >Manutenção</option>
                    <option value="abastecimento">Abastecimento</option>
                    <option value="limpeza">Limpeza</option>
                    <option value="dedetização">Dedetização</option>
                    <option value="dedetização">TESTE</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="observacao">Observação</label>
                <input name="observacao" type="text" class="form-control" id="observacao" placeholder="" value="">
            </div>
        </div>   
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">{{ $edit ? "Alterar" : "Cadastrar" }}</button>
            <button type="reset" class="btn btn-primary">Limpar</button>
        </div>
    </form>
</div>

@include('components.modal-camera')

<script>
    $('#user-image').change(function(){
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#photo').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    })
</script>

@endsection