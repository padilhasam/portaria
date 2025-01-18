@extends('layouts.dashboard')

@section('page_dashboard')

<header class="header-content">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Controle de Acessos</h3>
    </div>
</header>
<div class="container">
    <div class="">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('store.portaria') }}" method="POST">
                    @csrf
            
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
                            <label for="local_descricao">Apartamento</label>
                            {{-- Busca os apartamentos da tabela apartamentos --}}
                            <select class="form-control" name="local_descricao" id="local_descricao">
                                <option value=""> Selecione... </option>    
                                <option value="geral"> Geral </option>    
                                @foreach ($apartamentos as $apartamento)
                                    <option value="{{ $apartamento->id }}"> Apartamento {{ $apartamento->id }} - Bloco {{ $apartamento->bloco }} </option>    
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="observacao">Observação</label>
                            <input name="observacao" type="text" class="form-control" id="observacao" placeholder="" value="">
                        </div>
                        
                        </div>    
                        <div class="mt-4 col-12">
                            <button type="submit" class="btn btn-primary">{{ "Registrar" }}</button>
                            <button type="reset" class="btn btn-primary">Limpar</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-12 mt-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Foto</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Entrada</th>
                            <th scope="col">Saída</th>
                            <th scope="col">Identificação</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse ($moradores as $morador)
                            <tr>
                                <th scope="row">{{$morador->id}}</th>
                                <td>
                                    <img src="{{$morador->image}}" alt="{{$morador->image}}" style="width: 50px; border-radius: 100px;">
                                </td>
                                <td>{{$morador->nome}}</td>
                                <td>{{$morador->documento}}</td>
                                <td>{{$morador->birthdate}}</td>
                                <td>{{$morador->tel_fixo}}</td>
                                <td>{{$morador->celular}}</td>
                                <td>{{$morador->email}}</td>
                                <td>{{$morador->tipo_morador}}</td>
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
                                                <a class="dropdown-item" href="{{route('edit.morador', ['id' => $morador->id])}}">
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
                        @empty
                            <p>Nenhum morador cadastrado</p>
                        @endforelse --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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