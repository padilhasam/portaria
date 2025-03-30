<?php

use App\Http\Controllers\{
    LoginController,
    ApartamentoController,
    MoradorController,
    RegistroController,
    UsuarioController,
    VisitanteController,
    VeiculoController
};
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('pages.welcome');
})->name('welcome');

Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'index')->name('login.index');
    Route::get('/logout', 'destroy')->name('login.destroy');
    Route::post('/login', 'store')->name('login.store');
});

Route::controller(UsuarioController::class)->group(function(){
    Route::get('/usuario', 'index')->name('index.usuario');
    Route::get('/usuario/create', 'create')->name('create.usuario');
    Route::post('/usuario/store', 'store')->name('store.usuario');
    Route::get('/usuario/edit/{id}', 'edit')->name('edit.usuario');
    Route::put('/usuario/update/{id}', 'update')->name('update.usuario');
})->middleware(['auth'])->name('dashboard');

Route::controller(RegistroController::class)->group(function(){
    Route::get('/registro', 'index')->name('index.registro');
    Route::get('/registro/create', 'create')->name('create.registro');
    Route::post('/registro/store', 'store')->name('store.registro');
    Route::get('/registro/edit/{id}', 'edit')->name('edit.registro');
    Route::put('/registro/update/{id}', 'update')->name('update.registro');
})->middleware(['auth'])->name('dashboard');

Route::controller(ApartamentoController::class)->group(function(){
    Route::get('/apartamento', 'index')->name('index.apartamento');
    Route::get('/apartamento/create', 'create')->name('create.apartamento');
    Route::post('/apartamento/store', 'store')->name('store.apartamento');
    Route::get('/apartamento/edit/{id}', 'edit')->name('edit.apartamento');
    Route::put('/apartamento/update/{id}', 'update')->name('update.apartamento');
})->middleware(['auth'])->name('dashboard');

Route::controller(MoradorController::class)->group(function(){
    Route::get('/morador', 'index')->name('index.morador');
    Route::get('/morador/create', 'create')->name('create.morador');
    Route::post('/morador/store', 'store')->name('store.morador');
    Route::get('/morador/edit/{id}', 'edit')->name('edit.morador');
    Route::put('/morador/update/{id}', 'update')->name('update.morador');
})->middleware(['auth'])->name('dashboard');

Route::controller(VisitanteController::class)->group(function(){
    Route::get('/cadastro/visitante', 'index')->name('index.visitante');
    Route::get('/cadastro/visitante/create', 'create')->name('create.visitante');
    Route::get('/cadastro/visitante/store', 'store')->name('store.visitante');
})->middleware(['auth'])->name('dashboard');

Route::controller(VeiculoController::class)->group(function(){
    Route::get('/veiculo', 'index')->name('index.veiculo');
    Route::get('/veiculo/create', 'create')->name('create.veiculo');
    Route::post('/veiculo/store', 'store')->name('store.veiculo');
    Route::get('/veiculo/edit/{id}', 'edit')->name('edit.veiculo');
    Route::put('/veiculo/update/{id}', 'update')->name('update.veiculo');
})->middleware(['auth'])->name('dashboard');