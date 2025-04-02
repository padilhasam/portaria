@extends('layouts.dashboard')

@section('page_dashboard')

<header class="header-content">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Cadastro de Visitantes</h3>
        <a href="{{route('create.visitante')}}" class="btn text-white btn-primary">Cadastrar</a>
    </div>
</header>
<div class="">
    <div class="">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Nome</th>
                    <th scope="col">RG/CPF</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Observação</th>
                    <th scope="col">Data Criação</th>
                    <th scope="col">Data Alteração</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($visitantes as $visitante)
                    <tr>
                        <th scope="row">{{$visitante->id}}</th>
                        <td>{{$visitante->nome}}</td>
                        <td>{{$visitante->documento}}</td>
                        <td>{{$visitante->telefone}}</td>
                        <td>{{$visitante->image}}</td>
                        <td>{{$visitante->observacao}}</td>
                        <td>{{$visitante->created_at}}</td>
                        <td>{{$visitante->updated_at}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                    </svg>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#">Editar</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Remover</a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <p>Nenhum Visitante Criado</p>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection