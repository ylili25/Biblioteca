<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Editoriales
Route::get('editoriales/listado', [EditorialController::class, 'listado']);
Route::resource('editoriales',EditorialController::class);

//Libros
Route::resource('libros',LibroController::class);

//Prestamos
Route::get('listado/usuarios', [PrestamoController::class, 'usuariosListado']);
Route::get('listado/libros', [PrestamoController::class, 'librosListado']);
Route::get('prestamos', [PrestamoController::class, 'index'])->name('prestamos.index');
Route::post('prestamos', [PrestamoController::class, 'crearPrestamo']);
Route::get('prestamos/create', [PrestamoController::class, 'create'])->name('prestamos.create');
Route::get('prestamos/pendientes', [PrestamoController::class, 'prestamosPendientes'])->name('prestamos.pendientes');
Route::put('prestamos/{id}', [PrestamoController::class, 'devolverPrestamo']);


