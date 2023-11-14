@extends('layouts.dashboard')

@section('page_dashboard')

<div class="container">
    <h3 class="mb-4">Cadastro de Visitantes</h3>
    <form>
        @csrf
        <div class="form-group">
            <label for="cod_morador">Código: </label>
            <input type="number" class="form-control" id="cod_morador" value="1">
        </div>
        <div class="form-group">
            <label for="data_cadastro">Data de Cadastro: </label>
            <input type="date" class="form-control" id="data_cadastro">
        </div>
        <div class="form-group">
            <label for="nome_completo">Nome Completo: </label>
            <input type="text" class="form-control" id="nome_morador" placeholder="Digite o Nome Completo do Morador...">
        </div>
        <div class="form-group">
            <label for="cpf">CPF: </label>
            <input type="text" class="form-control" id="cpf" placeholder="000.000.000-00">
        </div>
        <div class="form-group">
            <label for="data_nascimento_morador">Data de Nascimento: </label>
            <input type="date" class="form-control" id="data_nasc_morador" placeholder="Data de Nascimento">
        </div>
        <div class="form-group">
            <label for="telefone">Celular: </label>
            <input type="tel" class="form-control" id="telefone_morador" placeholder="(00)0000-0000">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Email: </label>
            <input type="paemail" class="form-control" id="exampleInputPassword1" placeholder="email@email.com.br">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Foto: </label>
            <input type="file" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            <button type="submit" class="btn btn-primary">Editar</button>
            <button type="submit" class="btn btn-primary">Excluir</button>
            <button type="reset" class="btn btn-primary">Limpar</button>
        </div>
    </form>
</div>
   
@endsection