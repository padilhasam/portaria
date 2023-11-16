@extends('layouts.dashboard')

@section('page_dashboard')

<header class="header-content">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Moradores</h3>
        <a href="{{route('create.morador')}}" class="btn btn-primary">Cadastrar</a>
    </div>
</header>
<div class="container">
    <div class="">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">RG</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Aniversário</th>
                    <th scope="col">Telefone Fixo</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tipo Morador</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Data Criação</th>
                    <th scope="col">Data Alteração</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($moradores as $morador)
                    <tr>
                        <th scope="row">{{$morador->id}}</th>
                        <td>{{$morador->nome}}</td>
                        <td>{{$morador->rg}}</td>
                        <td>{{$morador->cpf}}</td>
                        <td>{{$morador->birthdate}}</td>
                        <td>{{$morador->tel_fixo}}</td>
                        <td>{{$morador->celular}}</td>
                        <td>{{$morador->email}}</td>
                        <td>{{$morador->tipo_morador}}</td>
                        <td>{{$morador->image}}</td>
                        <td>{{$morador->created_at}}</td>
                        <td>{{$morador->updated_at}}</td>
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
                    <p>Nenhum morador cadastrado</p>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection