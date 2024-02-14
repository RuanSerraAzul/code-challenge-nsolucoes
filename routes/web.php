<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', \App\Livewire\Login\Login::class)->name("login");

Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', \App\Livewire\Usuarios\Usuarios::class)->name("usuarios");

    Route::get('/logout', function () {
        $user = new \App\Livewire\Login\Login;
        $user->logout();
    })->name('logout');
});
