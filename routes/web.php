<?php

use Inertia\Inertia;
use App\Models\libro;
use App\Models\Rentado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\RentadoController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::resource('libros', App\Http\Controllers\LibroController::class);
Route::resource('rentados', App\Http\Controllers\RentadoController::class);
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $libros = libro::with('rentados')->get();
    $usuario = Auth::user();
    $rentados = Rentado::where('id_usuario', $usuario->id)->get();
    return Inertia::render('Dashboard', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'libros' => $libros,
        'rentados' => $rentados
    ]);
})->name('dashboard');
