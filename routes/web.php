<?php

use App\Http\Controllers\{
    LoginController,
    RegisterControler,
    ApartamentoController,
    MoradorController,
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

Route::controller(RegisterController::class)->group(function(){
    Route::get('/register', 'index')->name('index.register');
    Route::get('/register/create', 'create')->name('create.register');
    Route::post('/register/store', 'store')->name('store.register');
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
    Route::post('/morador/update/{id}', 'update')->name('update.morador');
})->middleware(['auth'])->name('dashboard');

Route::controller(VisitanteController::class)->group(function(){
    Route::get('/cadastro/visitante', 'index')->name('index.visitante');
    Route::get('/cadastro/visitante/create', 'create')->name('create.visitante');
    Route::get('/cadastro/visitante/store', 'store')->name('store.visitante');
})->middleware(['auth'])->name('dashboard');

Route::controller(VeiculoController::class)->group(function(){
    Route::get('/cadastro/veiculo', 'index')->name('index.veiculo');
    Route::get('/cadastro/veiculo/create', 'create')->name('create.veiculo');
    Route::get('/cadastro/veiculo/store', 'store')->name('store.veiculo');
})->middleware(['auth'])->name('dashboard');