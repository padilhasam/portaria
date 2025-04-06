@extends('layouts.dashboard')

@section('page_dashboard')

<header class="header-content">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Registros de Acessos</h3>
        <a href="{{route('create.registro')}}" class="btn text-white btn-dark">Cadastrar</a>
    </div>
</header>
<div class="">
    <div class="">
        <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Código</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Identificação</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Observação</th>
                        <th scope="col">Entrada</th>
                        <th scope="col">Saída</th>
                    </tr>
                </thead>
            <tbody>
                @forelse ($registros as $registro)
                    <tr>
                        <th scope="row">{{$registro->id}}</th>
                        <td>{{$registro->nome}}</td>
                        <td>{{$registro->identificacao}}</td>
                        <td>{{$registro->tipo}}</td>
                        <td>{{$registro->observacao}}</td>
                        <td>{{$registro->entrada}}</td>
                        <td>{{$registro->saida}}</td>
                        <td>{{$registro->created_at}}</td>
                        <td>{{$registro->updated_at}}</td>
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
                                    <li>
                                        <button class="dropdown-item" id="toggleButton">Ligar</button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <p>Nenhum registro criado</p>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById("toggleButton").addEventListener("click", function() {
        if (this.textContent === "Ligar") {
            this.textContent = "Desligar";
        } else {
            this.textContent = "Ligar";
        }
    });
</script>

@endsection