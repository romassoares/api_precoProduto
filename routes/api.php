<?php

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

Route::get('/', function () {
    return response()->json(['message' => 'page login']);
});

Route::post('login', AuthController::class, 'login');
Route::post('logout', AuthController::class, 'logout');
Route::post('refresh', AuthController::class, 'refresh');
Route::post('me', AuthController::class, 'me');


Route::middleware('auth:api')->group(function () {
    Route::get('/home', HomeController::class, 'index');

    // produto
    Route::group(['prefix' => '/produto'], function () {
        Route::get('', ProductController::class, 'index');
        Route::get('/novo', ProductController::class, 'create');
        Route::post('/salvar', ProductController::class, 'store');
        Route::get('/{id}/exibir', ProductController::class, 'show');
        Route::get('/{id}/editar', ProductController::class, 'edit');
        Route::put('/{id}/alterar', ProductController::class, 'update');
        Route::get('/{id}/remover', ProductController::class, 'destroy');
        Route::get('/removidos', ProductController::class, 'archive');
        Route::get('/{id}/restaurar', ProductController::class, 'restory');
    });

    // Ingredient
    Route::group(['prefix' => '/ingrediente'], function () {
        Route::get('', IngredientController::class, 'index');
        Route::get('/novo', IngredientController::class, 'create');
        Route::post('/salvar', IngredientController::class, 'store');
        Route::get('/{id}/exibir', IngredientController::class, 'show');
        Route::get('/{id}/editar', IngredientController::class, 'edit');
        Route::put('/{id}/altera', IngredientController::class, 'update');
        Route::get('/{id}/remover', IngredientController::class, 'destroy');
        Route::get('/removidos', IngredientController::class, 'archive');
        Route::get('/{id}/restaurar', IngredientController::class, 'restory');
    });

    // IngredientProduto
    Route::put('produto/{id}/altera-ingredient', ProductIngredientsController::class, 'update');
    Route::get('produto/{id}/remove-ingredient/{ing}', ProductIngredientsController::class, 'remove');
    Route::put('produto/{id}/restaura-ingredient', ProductIngredientsController::class, 'restore');
    Route::get('/{id}/quantidade-ingrediente/{ing}', ProductIngredientsController::class, 'Qnt');
    Route::put('produto/{id}/qnt', ProductIngredientsController::class, 'addQnt');

    Route::get('/relatorio', ReportController::class, 'index');

    // cliente
    Route::group(['prefix' => '/cliente'], function () {
        Route::get('', ClientController::class, 'index');
        Route::post('/pesquisar', ClientController::class, 'search');
        Route::get('/novo', ClientController::class, 'create');
        Route::post('/salvar', ClientController::class, 'store');
        Route::get('/{id}/editar', ClientController::class, 'edit');
        Route::put('/{id}/altera', ClientController::class, 'update');
        Route::get('/{id}/remover', ClientController::class, 'destroy');
        Route::get('/removidos', ClientController::class, 'archive');
        Route::get('/{id}/restaurar', ClientController::class, 'restory');
        Route::get('/{id}/relatorio', ClientController::class, 'report');
    });

    // venda
    Route::group(['prefix' => '/venda'], function () {
        Route::get('', SaleController::class, 'index');
        Route::put('/{id}/add-product', SaleController::class, 'addProduct');
        Route::post('/nova-venda', SaleController::class, 'store');
        Route::get('/{id}/exibir', SaleController::class, 'show');
        Route::get('/{id}/editar', SaleController::class, 'edit');
        Route::put('/{id}/altera', SaleController::class, 'update');
        Route::get('/{id}/remover', SaleController::class, 'destroy');
        Route::get('/{id}/removerItem/{item}', SaleController::class, 'removeItem');
        Route::get('/removidos', SaleController::class, 'archive');
        Route::get('/{id}/restaurar', SaleController::class, 'restory');
        Route::get('/relatorio', ReportController::class, 'index');
    });
});
