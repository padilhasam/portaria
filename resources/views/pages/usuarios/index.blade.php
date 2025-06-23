@extends('layouts.dashboard')

@section('page_dashboard')

<header class="mb-4 px-4 py-3 bg-white border rounded shadow-sm">

    {{-- Linha do título + botão --}}
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-3">
        <h3 class="m-0 fw-bold text-dark d-flex align-items-center gap-3" style="font-size: 1.75rem;">
            <span class="icon-container d-flex align-items-center justify-content-center"
                  style="width: 36px; height: 36px; background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-car-front-fill" viewBox="0 0 16 16">
                    <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2m10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17s3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z"/>
                </svg>
            </span>
            Controle de Usuários
        </h3>

        <a href="{{ route('create.usuario') }}" class="btn btn-primary btn-sm rounded-pill text-white">
            Novo Usuário
        </a>
    </div>

    {{-- Linha dos filtros --}}
    <form method="GET" action="{{ route('index.usuario') }}" class="row g-3 align-items-end">

        {{-- Buscar --}}
        <div class="col-12 col-md-4">
            <label for="search" class="form-label mb-1 small text-secondary">Buscar</label>
            <input type="text" name="search" id="search" class="form-control form-control-sm rounded-pill w-100"
                placeholder="Nome, CPF, e-mail..." value="{{ request('search') }}">
        </div>

        {{-- Perfil --}}
        <div class="col-6 col-md-2">
            <label for="perfil" class="form-label mb-1 small text-secondary">Perfil</label>
            <select name="tipo" id="perfil" class="form-select form-select-sm rounded w-100">
                <option value="">Todos</option>
                <option value="administrador" @selected(request('tipo') == 'administrador')>Administrador</option>
                <option value="padrao" @selected(request('tipo') == 'padrao')>Usuário</option>
            </select>
        </div>

        {{-- Status --}}
        <div class="col-6 col-md-2">
            <label for="status" class="form-label mb-1 small text-secondary">Status</label>
            <select name="status" id="status" class="form-select form-select-sm rounded w-100">
                <option value="">Todos</option>
                <option value="ATIVO" @selected(request('status') == 'ATIVO')>Ativo</option>
                <option value="BLOQUEADO" @selected(request('status') == 'BLOQUEADO')>Bloqueado</option>
                <option value="FÉRIAS" @selected(request('status') == 'FÉRIAS')>Férias</option>
            </select>
        </div>

        {{-- Data de Criação Início --}}
        <div class="col-6 col-md-1">
            <label for="data_inicio" class="form-label mb-1 small text-secondary">De</label>
            <input type="date" name="data_inicio" id="data_inicio" class="form-control form-control-sm w-100"
                value="{{ request('data_inicio') }}">
        </div>

        {{-- Data de Criação Fim --}}
        <div class="col-6 col-md-1">
            <label for="data_fim" class="form-label mb-1 small text-secondary">Até</label>
            <input type="date" name="data_fim" id="data_fim" class="form-control form-control-sm w-100"
                value="{{ request('data_fim') }}">
        </div>

        {{-- Botões --}}
        <div class="col-12 col-md-2 d-flex gap-2 justify-content-md-end justify-content-start flex-wrap">
            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 mb-2 mb-md-0">🔍 Filtrar</button>
            <a href="{{ route('index.usuario') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4 mb-2 mb-md-0">❌ Limpar</a>
        </div>

    </form>
</header>

<!-- Exibição de mensagens de sucesso ou erro -->
<div>
    @include('components.alerts', [
        'success' => session()->get('success'),
        'message' => session()->get('message')
    ])
</div>


<div class="card shadow-sm border-0 rounded-4" style="min-height: 600px;">
    <div class="card-body d-flex flex-column">
        <h5 class="card-title mb-3 fw-semibold">Lista de Usuários</h5>

                <div class="table-responsive flex-grow-1">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Data de Nascimento</th>
                                <th>Celular</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Criado em</th>
                                <th>Atualizado em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($usuarios as $usuario)
                                <tr>
                                    <td><span class="badge bg-primary text-white">{{$usuario->nome}}</td>
                                    <td>{{$usuario->documento}}</td>
                                    <td>{{\Carbon\Carbon::parse($usuario->nascimento)->format('d/m/Y') }}</td>
                                    <td>{{$usuario->celular}}</td>
                                    <td>{{$usuario->email}}</td>
                                    <td>{{$usuario->status}}</td>
                                    <td>{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $usuario->updated_at ? $usuario->updated_at->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi" viewBox="0 0 16 16">
                                                    <path d="M8 3.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"/>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end show-on-top">
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('edit.usuario', $usuario->id) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#0d6efd" viewBox="0 0 16 16">
                                                            <path d="M12.146.854a.5.5 0 0 1 .708 0l2.292 2.292a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-4 1.5a.5.5 0 0 1-.65-.65l1.5-4a.5.5 0 0 1 .11-.168l10-10zM11.207 2L13 3.793 14.293 2.5 12.5.707 11.207 2zM12 4.207 11.793 4 3 12.793 3.207 13 12 4.207zM2.5 13.5 4 13l-.5-.5-1.5.5.5 1.5z"/>
                                                        </svg>
                                                        Editar
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $usuario->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M5.5 5.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 1 1 0V12a.5.5 0 0 1-1 0V6zm3-.5a.5.5 0 0 1 .5.5V12a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5z"/>
                                                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2h4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h4a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3a.5.5 0 0 0 0 1H13.5a.5.5 0 0 0 0-1H2.5z"/>
                                                        </svg>
                                                        Remover
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal para confirmação de remoção -->
                                <div class="modal fade" id="removeItemModal-{{ $usuario->id }}" tabindex="-1" aria-labelledby="removeItemModalLabel-{{ $usuario->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="removeItemModalLabel-{{ $usuario->id }}">Confirmar remoção</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                            </div>
                                            <div class="modal-body">
                                                Tem certeza que deseja remover o usuário <strong>{{ $usuario->nome }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('destroy.usuario', ['id' => $usuario->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Remover</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center">Nenhum morador cadastrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
    </div>
</div>

@endsection
