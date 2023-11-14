<?php

use App\Http\Controllers\{
    ImovelController,
    LoginController,
    MoradorController,
    VisitanteController
};
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'index')->name('login.index');
    Route::get('/logout', 'destroy')->name('login.destroy');
    Route::post('/login', 'store')->name('login.store');
});

Route::controller(ImovelController::class)->group(function(){
    Route::get('/imovel', 'index')->name('index.imovel');
    Route::get('/imovel/create', 'create')->name('create.imovel');
    Route::post('/imovel/store', 'store')->name('store.imovel');
})->middleware(['auth'])->name('dashboard');

Route::controller(MoradorController::class)->group(function(){
    Route::get('/morador', 'index')->name('index.morador');
    Route::get('/morador/create', 'create')->name('create.morador');
    Route::post('/morador/store', 'store')->name('store.morador');
})->middleware(['auth'])->name('dashboard');

Route::controller(VisitanteController::class)->group(function(){
    Route::get('/visitante', 'index')->name('index.visitante');
    Route::get('/visitante/create', 'create')->name('create.visitante');
    Route::get('/visitante/store', 'store')->name('store.visitante');
})->middleware(['auth'])->name('dashboard');