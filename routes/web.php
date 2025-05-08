<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Padre\PadreController;
use App\Http\Controllers\ProfesorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta protegida de ejemplo
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.home');
    })->name('admin.home');

    Route::get('/profesor', [ProfesorController::class, 'home'])->name('profesor.home');


    Route::get('/padre', [PadreController::class, 'index'])->name('padre.home');


});


Route::get('/padre/alumno/{alumno}', [AlumnoController::class, 'showAlumno'])
    ->name('alumno.detalle.padre')
    ->middleware(['auth']);

Route::get('/profesor/alumno/{alumno}', [AlumnoController::class, 'showAlumno'])
    ->name('alumno.detalle.profesor')
    ->middleware(['auth']);

