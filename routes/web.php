<?php

use App\Http\Controllers\{
    LoginController,
    MoradorController,
    VisitanteController,
    VeiculoController
};
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'index')->name('login.index');
    Route::get('/logout', 'destroy')->name('login.destroy');
    Route::post('/login', 'store')->name('login.store');
});

Route::controller(MoradorController::class)->group(function(){
    Route::get('/cadastro/morador', 'index')->name('index.morador');
    Route::get('/cadastro/morador/create', 'create')->name('create.morador');
    Route::post('/cadastro/morador/store', 'store')->name('store.morador');
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