<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\FornecedoresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Rotas categorias
Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias.index');
Route::post('/categorias', [CategoriasController::class, 'store'])->name('categorias.store');
Route::put('/categorias/{id}', [CategoriasController::class, 'update'])->name('categoria.update');
Route::delete('/categorias/{id}', [CategoriasController::class, 'destroy'])->name('categoria.destroy');

// Rotas fornecedores
Route::get('/fornecedores', [FornecedoresController::class, 'index'])->name('fornecedores.index');