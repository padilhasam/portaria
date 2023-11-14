@extends('layouts.dashboard')

@section('page_dashboard')

<div class="container">
    <h3 class="mb-4">Cadastro de imóvel</h3>
    <form action="{{route('store.imovel')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="bloco">Bloco</label>
            <input name="bloco" type="text" class="form-control" id="bloco" placeholder="Digite o bloco do imóvel">
        </div>
        <div class="form-group">
            <label for="numero">Número</label>
            <input name="numero" type="text" class="form-control" id="numero" placeholder="Número do imóvel">
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <button type="reset" class="btn btn-primary">Limpar</button>
        </div>
    </form>
</div>

@endsection