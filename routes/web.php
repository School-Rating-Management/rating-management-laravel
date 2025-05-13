<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\Padre\PadreController;
use App\Http\Controllers\ProfesorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta protegida de ejemplo
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.panel');


    Route::get('/profesor', [ProfesorController::class, 'home'])->name('profesor.home');
    Route::get('/profesor/materia/{id}', [ProfesorController::class, 'verMateria'])->name('profesor.materia');
    Route::get('/profesor/materia/{materia}/alumno/{alumno}/editar', [ProfesorController::class, 'editarCalificacion'])->name('profesor.calificacion.edit');
    Route::post('/profesor/materia/{materia}/alumno/{alumno}/actualizar', [ProfesorController::class, 'actualizarCalificacion'])->name('profesor.calificacion.update');


    Route::get('/padre', [PadreController::class, 'index'])->name('padre.home');


});


Route::get('/padre/alumno/{alumno}', [AlumnoController::class, 'showAlumno'])
    ->name('alumno.detalle.padre')
    ->middleware(['auth']);

Route::get('/profesor/alumno/{alumno}', [AlumnoController::class, 'showAlumno'])
    ->name('alumno.detalle.profesor')
    ->middleware(['auth']);

Route::middleware(['auth', 'is_admin'])->group(function () {
    // Materias: Rutas para ver inactivos, restaurar y eliminar permanentemente
    Route::get('/materias/inactivas', [MateriaController::class, 'inactivas'])->name('materias.inactivas');
    Route::post('/materias/{id}/restore', [MateriaController::class, 'restore'])->name('materias.restore');
    Route::delete('/materias/{id}/delete', [MateriaController::class, 'forceDelete'])->name('materias.forceDelete');
    Route::resource('materias', MateriaController::class);


    // Profesores: Rutas para ver inactivos, restaurar y eliminar permanentemente
    Route::get('/profesores/inactivos', [ProfesorController::class, 'inactivos'])->name('profesores.inactivos');

    Route::resource('profesores', ProfesorController::class);
    Route::post('/profesores/{id}/restore', [ProfesorController::class, 'restore'])->name('profesores.restore');
    Route::delete('/profesores/{id}/delete', [ProfesorController::class, 'forceDelete'])->name('profesores.forceDelete');
    Route::get('/profesores/{id}/asignar-grupo', [ProfesorController::class, 'asignarGrupo'])->name('profesores.asignarGrupo');
    Route::post('/profesores/{id}/guardar-grupo', [ProfesorController::class, 'guardarGrupo'])->name('profesores.guardarGrupo');

    // Grados: Rutas para ver inactivos, restaurar y eliminar permanentemente
    Route::get('/grados/inactivos', [GradoController::class, 'inactivos'])->name('grados.inactivos');
    Route::post('/grados/{id}/restore', [GradoController::class, 'restore'])->name('grados.restore');
    Route::delete('/grados/{id}/delete', [GradoController::class, 'forceDelete'])->name('grados.forceDelete');
    Route::resource('grados', GradoController::class);

    // Grupos: Rutas para ver inactivos, restaurar y eliminar permanentemente
    Route::get('/grupos/inactivos', [GrupoController::class, 'inactivas'])->name('grupos.inactivas');
    Route::post('/grupos/{id}/restore', [GrupoController::class, 'restore'])->name('grupos.restore');
    Route::delete('/grupos/{id}/delete', [GrupoController::class, 'forceDelete'])->name('grupos.forceDelete');
    Route::resource('grupos', GrupoController::class);

    Route::resource('ciclos', CicloController::class);
});


