@extends('layouts.dashboard')

@section('page_dashboard')

<x-modal-remove-item/>
<header class="header-content">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Cadastro de Apartamentos</h3>
        <a href="{{route('create.apartamento')}}" class="btn text-white btn-dark">Cadastrar</a>
    </div>
</header>
<div class="">
    <div class="">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Apartamento</th>
                    <th scope="col">Bloco</th>
                    <th scope="col">Vaga</th>
                    <th scope="col">Ramal</th>
                    <th scope="col">Situação</th>
                    <th scope="col">Status da Vaga</th>
                    <th scope="col">Data Criação</th>
                    <th scope="col">Data Alteração</th>
                    <th scope="col">Opções</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apartamentos as $apartamento)
                    <tr>
                        <th scope="row">{{$apartamento->numero}}</th>
                        <td>{{$apartamento->bloco}}</td>
                        <td>{{$apartamento->vaga}}</td>
                        <td>{{$apartamento->ramal}}</td>
                        <td>{{$apartamento->situacao}}</td>
                        <td>{{$apartamento->status_vaga}}</td>
                        <td>{{$apartamento->created_at}}</td>
                        <td>{{$apartamento->updated_at}}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                        <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                    </svg>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{route('edit.apartamento', ['id' => $apartamento->id])}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                            </svg>
                                            Editar
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-danger" type="button" data-bs-toggle="modal" data-bs-target="#removeItemModal" href="#">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                            </svg>
                                            Remover
                                        </a>
                                    </li>
                                </ul>
                              </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

