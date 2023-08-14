<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\MovimentoEstoqueController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\SetoresController;
use App\Http\Controllers\ColaboradoresController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PerfillController;
use App\Models\LoginSecurity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use function PHPSTORM_META\map;

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

Route::middleware('auth:sanctum')->group(function () {
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
    Route::post('/movimento-estoque', [MovimentoEstoqueController::class, 'store'])->name('movimento-estoque.store');

    //Rotas produtos
    Route::get('/produtos', [ProdutosController::class, 'index'])->name('produtos.index');
    Route::post('/produtos', [ProdutosController::class, 'store'])->name('produtos.store');
    Route::put('/produtos', [ProdutosController::class, 'update'])->name('produtos.update');

    // Rotas colaboradores
    Route::get('/colaboradores', [ColaboradoresController::class, 'index'])->name('colaboradores.index');
    Route::post('/colaboradores', [ColaboradoresController::class, 'importar'])->name('colaboradores.store');

    Route::post('/logout', [UserController::class, 'logout'])->name('login.logout');

    Route::post('/logout', [UserController::class, 'logout'])->name('login.logout');

    //routes perfil
    Route::get('/perfil', [PerfillController::class, 'listar'])->name('perfil.listar');
    Route::get('/perfil/permissao/{id}', [PerfillController::class, 'listarPermissao'])->name('perfil.listar.permissao');
    Route::post('/perfil', [PerfillController::class, 'create'])->name('perfil.create');
    Route::post('/perfil/{id}', [PerfillController::class, 'permissao'])->name('perfil.permissao');

    // Rotas roles
    Route::get('/roles', [RoleController::class, 'listar'])->name('roles.listar');
    Route::post('/roles', [RoleController::class, 'create'])->name('roles.create');
    
});

//Rotas login
Route::post('/login', [UserController::class, 'login'])->name('login.login');

