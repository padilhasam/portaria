@extends('layouts.dashboard')

@section('page_dashboard')

<header class="header-content">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Cadastro de Veículos</h3>
        <a href="{{route('create.veiculo')}}" class="btn text-white btn-dark">Cadastrar</a>
    </div>
</header>
<div class="">
    <div class="">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Cor</th>
                    <th scope="col">Observação</th>
                    <th scope="col">Data Criação</th>
                    <th scope="col">Data Alteração</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($veiculos as $veiculo)
                    <tr>
                        <th scope="row">{{$veiculo->id}}</th>
                        <td>{{$veiculo->placa}}</td>
                        <td>{{$veiculo->tipo}}</td>
                        <td>{{$veiculo->marca}}</td>
                        <td>{{$veiculo->modelo}}</td>
                        <td>{{$veiculo->cor}}</td>
                        <td>{{$veiculo->observacao}}</td>
                        <td>{{$veiculo->created_at}}</td>
                        <td>{{$veiculo->updated_at}}</td>
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
                <tr>
                    <td colspan="13" class="text-center">Nenhum veículo cadastrado</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection