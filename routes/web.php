<?php

use App\Http\Controllers\{
    LoginController,
    RegisterControler,
    ApartamentoController,
    MoradorController,
    PortariaRegistroController,
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

Route::controller(PortariaRegistroController::class)->group(function(){
    Route::get('/portaria', 'index')->name('index.portaria');
    Route::get('/portaria/create', 'create')->name('create.portaria');
    Route::post('/portaria/store', 'store')->name('store.portaria');
    Route::get('/portaria/edit/{id}', 'edit')->name('edit.portaria');
    Route::put('/portaria/update/{id}', 'update')->name('update.portaria');
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