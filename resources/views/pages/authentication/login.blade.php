@extends('layouts.app')

@if (auth()->check())
    <?php header('Location: ' . route('create.apartamento')) ?>
@else

    @section('content_login')
        <div class="container-fluid" style="background: url({{Vite::asset('resources/images/background_login.png')}})">
            <div class="container">
                <div class="vh-100 w-100 d-flex align-items-center justify-content-center">
                    <form action={{route('login.store')}} method="POST" class="form col-12 col-sm- col-md-6 col-lg-4">
                        @csrf
                        
                        <img src={{ Vite::asset('resources/images/logo.png') }} class="logo mx-auto d-block mb-3 w-50">
                        
                        <h2 class="text-center mb-0 mt-4" id="saudacao"></h2>
                        <p class="text-white text-center mb-4">Faça login para acessar sua conta.</p>

                        @error('error')
                            <p class="alert alert-secondary" role="alert">{{ $message }}</p>
                        @enderror
                        
                        <div class="form-group">
                            <label class="text-white">Usuário</label>
                            <input type="email" class="form-control df-input" name="email" value="" required>
                            @error('email')
                                <p class="alert alert-secondary" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group mt-2 mb-2">
                            <label class="text-white">Senha</label>
                            <input type="password" class="form-control df-input" name="password" value="" required>
                            @error('password')
                                <p class="alert alert-secondary" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-4 w-100 p-2">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    @endsection
@endif
@vite(['resources/js/saudacao.js'])