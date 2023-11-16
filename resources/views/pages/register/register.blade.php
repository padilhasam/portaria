@extends('layouts.dashboard')

@section('page_dashboard')

<div class="container">
    <h3 class="mb-4">Cadastro de Usuários</h3>
    <form action="{{route('store.register')}}" method="POST">
        @csrf
        
        

    </form>
</div>

@endsection