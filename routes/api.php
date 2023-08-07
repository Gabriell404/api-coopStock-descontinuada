<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\MovimentoEstoqueController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\SetoresController;
use App\Http\Controllers\ColaboradoresController;

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
Route::post('/fornecedores', [FornecedoresController::class, 'store'])->name('fornecedores.store');
Route::put('/fornecedores/{id}', [FornecedoresController::class, 'update'])->name('fornecedores.update');
Route::delete('/fornecedores/{id}', [FornecedoresController::class, 'destroy'])->name('fornecedores.destroy');

// Rotas setores 
Route::get('/setores', [SetoresController::class, 'index'])->name('setores.index');
Route::post('/setores', [SetoresController::class, 'store'])->name('setores.store');
Route::delete('/setores/{id}', [SetoresController::class, 'destroy'])->name('setores.destroy');

// Rotas movimento_estoque
Route::get('/movimento-estoque', [MovimentoEstoqueController::class, 'index'])->name('movimento-estoque.index');

//Rotas produtos
Route::get('/produtos', [ProdutosController::class, 'index'])->name('produtos.index');
Route::post('/produtos', [ProdutosController::class, 'store'])->name('produtos.store');

// Rotas colaboradores
Route::post('/colaboradores', [ColaboradoresController::class, 'importar'])->name('colaboradores.store');