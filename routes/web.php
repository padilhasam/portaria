<?php

use App\Http\Controllers\{
    LoginController,
    ApartamentoController,
    MoradorController,
    RegistroController,
    UsuarioController,
    VisitanteController,
    VeiculoController,
    AgendamentoController,
    RelatorioController
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
    Route::delete('/usuario/{id}', 'destroy')->name('destroy.usuario');
})->middleware(['auth'])->name('dashboard');

Route::controller(RegistroController::class)->group(function(){
    Route::get('/registro', 'index')->name('index.registro');
    Route::get('/registro/create', 'create')->name('create.registro');
    Route::post('/registro', 'store')->name('store.registro');
    Route::get('/registro/{id}/edit', 'edit')->name('edit.registro');
    Route::put('/registro/{id}', 'update')->name('update.registro');
    Route::delete('/registro/{id}', 'destroy')->name('destroy.registro');
    Route::post('/registro/{id}/saida', 'registrarSaida')->name('saida.registro');
})->middleware(['auth'])->name('dashboard');

Route::controller(ApartamentoController::class)->group(function(){
    Route::get('/apartamento', 'index')->name('index.apartamento');
    Route::get('/apartamento/create', 'create')->name('create.apartamento');
    Route::post('/apartamento/store', 'store')->name('store.apartamento');
    Route::get('/apartamento/edit/{id}', 'edit')->name('edit.apartamento');
    Route::put('/apartamento/update/{id}', 'update')->name('update.apartamento');
    Route::delete('/apartamento/{id}', 'destroy')->name('destroy.apartamento');
    Route::get('/apartamento/{id}/details', 'getDetails')->name('apartamento.details');
})->middleware(['auth'])->name('dashboard');

Route::controller(MoradorController::class)->group(function(){
    Route::get('/morador', 'index')->name('index.morador');
    Route::get('/morador/create', 'create')->name('create.morador');
    Route::post('/morador', 'store')->name('store.morador');
    Route::get('/morador/{id}', 'show')->name('show.morador');
    Route::get('/morador/{id}/edit', 'edit')->name('edit.morador');
    Route::put('/morador/{id}', 'update')->name('update.morador');
    Route::delete('/morador/{id}', 'destroy')->name('destroy.morador');
    
    // Rota para preenchimento automático de moradores
    Route::get('/morador/search', 'search')->name('search.morador');
})->middleware(['auth'])->name('dashboard');

Route::controller(VisitanteController::class)->group(function(){
    Route::get('/visitante', 'index')->name('index.visitante');
    Route::get('/visitante/create', 'create')->name('create.visitante');
    Route::post('/visitante', 'store')->name('store.visitante');
    Route::get('/visitante/{id}/edit', 'edit')->name('edit.visitante');
    Route::put('/visitante/{id}', 'update')->name('update.visitante');
    Route::delete('/visitante/{id}', 'destroy')->name('destroy.visitante');
    Route::post('/visitante/{id}/saida', 'registrarSaida')->name('saida.visitante');
})->middleware(['auth'])->name('dashboard');

Route::controller(VeiculoController::class)->group(function(){
    Route::get('/veiculo', 'index')->name('index.veiculo');
    Route::get('/veiculo/create', 'create')->name('create.veiculo');
    Route::post('/veiculo/store', 'store')->name('store.veiculo');
    Route::get('/veiculo/edit/{id}', 'edit')->name('edit.veiculo');
    Route::put('/veiculo/update/{id}', 'update')->name('update.veiculo');
    
    // Rota para preenchimento automático de veículos
    Route::get('/veiculo/search', 'search')->name('search.veiculo');

    Route::get('/veiculo/{id}/details', 'getDetails')->name('veiculo.details');
})->middleware(['auth'])->name('dashboard');

Route::controller(AgendamentoController::class)->group(function() {
    Route::get('/agendamento', 'index')->name('index.agendamento');
    Route::get('/agendamento/create', 'create')->name('create.agendamento');
    Route::post('/agendamento/store', 'store')->name('store.agendamento');
    Route::get('/agendamento/edit/{id}', 'edit')->name('edit.agendamento');
    Route::put('/agendamento/update/{id}', 'update')->name('update.agendamento');
    Route::delete('/agendamento/{id}', 'destroy')->name('destroy.agendamento');
})->middleware(['auth'])->name('dashboard');

// routes/web.php
Route::get('/relatorios', [RelatorioController::class, 'index'])->name('index.relatorio');
Route::get('/relatorios/export', [RelatorioController::class, 'export'])->name('export.relatorio');