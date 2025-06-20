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
    NotificacaoController,
    RelatorioController,
    PrestadorController,
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
    Route::post('/registro-by-idvisitante/{id}/details', 'getRegisterByVisitante')->name('registro.byidvisitante');

})->middleware(['auth'])->name('dashboard');

Route::controller(ApartamentoController::class)->group(function(){
    Route::get('/apartamento', 'index')->name('index.apartamento');
    Route::get('/apartamento/create', 'create')->name('create.apartamento');
    Route::post('/apartamento/store', 'store')->name('store.apartamento');
    Route::get('/apartamento/edit/{id}', 'edit')->name('edit.apartamento');
    Route::put('/apartamento/update/{id}', 'update')->name('update.apartamento');
    Route::delete('/apartamento/{id}', 'destroy')->name('destroy.apartamento');
    Route::post('/apartamento/{id}/details', 'getDetailsApartamento')->name('apartamento.details');
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
    Route::delete('/veiculo/{id}', 'destroy')->name('destroy.veiculo');
    
    // Rota para preenchimento automático de veículos
    Route::get('/veiculo/search', 'search')->name('search.veiculo');

    Route::post('/veiculo/{id}/details', 'getDetails')->name('veiculo.details');
})->middleware(['auth'])->name('dashboard');

Route::controller(AgendamentoController::class)->group(function() {
    Route::get('/agendamento', 'index')->name('index.agendamento');
    Route::get('/agendamento/create', 'create')->name('create.agendamento');
    Route::post('/agendamento/store', 'store')->name('store.agendamento');
    Route::get('/agendamento/edit/{id}', 'edit')->name('edit.agendamento');
    Route::put('/agendamento/update/{id}', 'update')->name('update.agendamento');
    Route::delete('/agendamento/{id}', 'destroy')->name('destroy.agendamento');
})->middleware(['auth'])->name('dashboard');

Route::controller(NotificacaoController::class)->group(function() {
    Route::get('/notificacao', 'index')->name('index.notificacao');
    Route::get('/notificacao/create', 'create')->name('create.notificacao');
    Route::post('/notificacao', 'store')->name('store.notificacao');
    Route::get('/notificacao/edit/{id}', 'edit')->name('edit.notificacao');
    Route::get('/notificacao/{id}', 'show')->name('show.notificacao');
    Route::patch('/notificacao/{id}/ler', 'marcarComoLida')->name('notificacoes.marcar_como_lida');
    Route::patch('/notificacoes/marcar-todas', 'marcarTodasComoLidas')->name('notificacoes.marcar_todas_como_lidas');
    Route::delete('/notificacao/{id}', 'destroy')->name('destroy.notificacao');
    Route::get('/notificacoes/{id}/respostas', 'verRespostas')->name('notificacoes.respostas');
    Route::post('notificacoes/{id}/responder', 'responder')->name('notificacoes.enviar_resposta');
})->middleware(['auth']);

Route::controller(PrestadorController::class)->group(function () {
    Route::get('/prestador', 'index')->name('index.prestador');
    Route::get('/prestador/create', 'create')->name('create.prestador');
    Route::post('/prestador/store', 'store')->name('store.prestador');
    Route::get('/prestador/edit/{id}', 'edit')->name('edit.prestador');
    Route::put('/prestador/update/{id}', 'update')->name('update.prestador');
    Route::delete('/prestador/{id}', 'destroy')->name('destroy.prestador');
})->middleware(['auth'])->name('dashboard');

// routes/web.php
Route::get('/relatorios', [RelatorioController::class, 'index'])->name('index.relatorio');
Route::get('/relatorios/export', [RelatorioController::class, 'export'])->name('export.relatorio');