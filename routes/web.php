<?php

use App\Http\Controllers\{
    // DashboardController,
    LoginController,
    MoradorController,
    VisitanteController
};
use Illuminate\Support\Facades\Route;

Route::controller(DashboardController::class)->group(function(){
    //Route::get('/', 'index')->name('vehicle.index');
    //Route::get('/vehicle/{id}', 'show')->name('vehicle.show');
    //Route::put('/vehicle/update/{id}', 'update')->name('vehicle.update');
    //Route::post('/vehicle', 'store')->name('vehicle.store');
    //Route::delete('/vehicle/delete/{id}', 'delete')->name('vehicle.delete');
})->middleware(['auth'])->name('dashboard');

Route::controller(LoginController::class)->group(function(){
    Route::get('/login', 'index')->name('login.index');
    Route::get('/logout', 'destroy')->name('login.destroy');
    Route::post('/login', 'store')->name('login.store');
});
Route::controller(MoradorController::class)->group(function(){
    Route::get('/cadastro/morador', 'create')->name('create.morador');
});
Route::controller(VisitanteController::class)->group(function(){
    Route::get('/cadastro/visitante', 'create')->name('create.visitante');
});