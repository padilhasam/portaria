@extends('layouts.app')

@section('content_login')
@if (auth()->check())
    <script>window.location.href = "{{ route('create.registro') }}";</script>
@else
<div class="d-flex flex-column min-vh-100">

    <!-- Área principal com fundo -->
    <main class="flex-fill d-flex align-items-center" style="background: url('{{ Vite::asset('resources/images/background_login_claro.png') }}'); background-size: cover; background-position: center;">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100%;">
            <form action="{{ route('login.store') }}" method="POST" class="form col-12 col-sm-8 col-md-6 col-lg-4 bg-white">
                @csrf
                <img src="{{ Vite::asset('resources/images/logo_black.png') }}" class="logo mx-auto d-block mb-3 w-75">

                <h2 class="text-center mb-0 mt-4" id="saudacao"></h2>
                <p class="text-center mb-4">Para acessar, faça seu login.</p>

                @error('error')
                    <p class="alert alert-danger fade-out-message" role="alert">{{ $message }}</p>
                @enderror

                <div class="form-group">
                    <label class="text-black">Usuário</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            {{ svg('hugeicons-mail-account-01') }}
                        </span>
                        <input type="email" class="form-control" placeholder="example@company.com" name="email" id="email" required>
                    </div>
                    @error('email')
                        <p class="alert alert-danger fade-out-message" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group mt-2 mb-2">
                    <label class="text-black">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon2">
                            {{ svg('hugeicons-lock-password') }}
                        </span>
                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
                    </div>
                    @error('password')
                        <p class="alert alert-danger fade-out-message" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn text-white btn-dark mt-4 w-100 p-2">Entrar</button>
            </form>
        </div>
    </main>

    <!-- Footer fixo ao fim da tela -->
    <footer class="text-center text-muted py-3 bg-light small">
        &copy; {{ date('Y') }} Jeferson M. Padilha - Todos os direitos reservados
    </footer>
</div>

@vite(['resources/js/saudacao.js'])
@endif
@endsection
