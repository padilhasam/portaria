@extends('layouts.app')

@if (auth()->check())
    <?php header('Location: ' . route('create.registro')) ?>
@else

    @section('content_login')
        <div class="container-fluid" style="background: url({{Vite::asset('resources/images/background_login.png')}})">
            <div class="container">
                <div class="vh-100 w-100 d-flex align-items-center justify-content-center">
                    <form action={{route('login.store')}} method="POST" class="form col-12 col-sm- col-md-6 col-lg-4">
                        @csrf
                        
                        <img src={{ Vite::asset('resources/images/logo_black.png') }} class="logo mx-auto d-block mb-3 w-75">
                        
                        <h2 class="text-center mb-0 mt-4" id="saudacao"></h2>
                        <p class="text-black text-center mb-4">Para acessar, faça seu login.</p>

                        @error('error')
                            <p class="alert alert-secondary" role="alert">{{ $message }}</p>
                        @enderror
                        
                        <div class="form-group">
                            <label class="text-black">Usuário</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    {{ svg('hugeicons-mail-account-01') }}
                                </span>
                                <input type="email" class="form-control" placeholder="example@company.com" name="email" value="" id="email" autofocus required>
                            </div> 
                            @error('email')
                                <p class="alert alert-secondary" role="alert">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group mt-2 mb-2">
                            <label class="text-black">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon2">
                                    {{ svg('hugeicons-lock-password') }}
                                </span>
                                <input type="password" class="form-control" placeholder="Password" name="password" value="" id="password" required>
                            </div>
                            @error('password')
                                <p class="alert alert-secondary" role="alert">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn text-white btn-dark mt-4 w-100 p-2">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    @endsection
@endif
@vite(['resources/js/saudacao.js'])