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

// Route::get('/', function () {
//     return response()->json(['message' => 'page login']);
// });

Route::post('login', 'AuthController@login');
Route::post('refresh', 'AuthController@refresh');

Route::middleware('auth:api')->group(function () {
    Route::post('me', 'AuthController@me');
    Route::post('logout', 'AuthController@logout');

    Route::get('/home', 'HomeController@index');

    // produto
    Route::group(['prefix' => '/produto'], function () {
        Route::get('', 'ProductController@index');
        Route::get('/novo', 'ProductController@create');
        Route::post('/salvar', 'ProductController@store');
        Route::get('/{id}/exibir', 'ProductController@show');
        Route::get('/{id}/editar', 'ProductController@edit');
        Route::put('/{id}/alterar', 'ProductController@update');
        Route::get('/{id}/remover', 'ProductController@destroy');
        Route::get('/removidos', 'ProductController@archive');
        Route::get('/{id}/restaurar', 'ProductController@restory');
    });

    // Ingredient
    Route::group(['prefix' => '/ingrediente'], function () {
        Route::get('', 'IngredientController@index');
        Route::get('/novo', 'IngredientController@create');
        Route::post('/salvar', 'IngredientController@store');
        Route::get('/{id}/exibir', 'IngredientController@show');
        Route::get('/{id}/editar', 'IngredientController@edit');
        Route::put('/{id}/altera', 'IngredientController@update');
        Route::get('/{id}/remover', 'IngredientController@destroy');
        Route::get('/removidos', 'IngredientController@archive');
        Route::get('/{id}/restaurar', 'IngredientController@restory');
    });

    // IngredientProduto
    Route::put('produto/{id}/altera-ingredient', 'ProductIngredientsController@update');
    Route::get('produto/{id}/remove-ingredient/{ing}', 'ProductIngredientsController@remove');
    Route::put('produto/{id}/restaura-ingredient', 'ProductIngredientsController@restore');
    Route::get('/{id}/quantidade-ingrediente/{ing}', 'ProductIngredientsController@Qnt');
    Route::put('produto/{id}/qnt', 'ProductIngredientsController@addQnt');

    Route::get('/relatorio', 'ReportController@index');

    // cliente
    Route::group(['prefix' => '/cliente'], function () {
        Route::get('', 'ClientController@index');
        Route::post('/pesquisar', 'ClientController@search');
        Route::get('/novo', 'ClientController@create');
        Route::post('/salvar', 'ClientController@store');
        Route::get('/{id}/editar', 'ClientController@edit');
        Route::put('/{id}/altera', 'ClientController@update');
        Route::get('/{id}/remover', 'ClientController@destroy');
        Route::get('/removidos', 'ClientController@archive');
        Route::get('/{id}/restaurar', 'ClientController@restory');
        Route::get('/{id}/relatorio', 'ClientController@report');
    });

    // venda
    Route::group(['prefix' => '/venda'], function () {
        Route::get('', 'SaleController@index');
        Route::put('/{id}/add-product', 'SaleController@addProduct');
        Route::post('/nova-venda', 'SaleController@store');
        Route::get('/{id}/exibir', 'SaleController@show');
        Route::get('/{id}/editar', 'SaleController@edit');
        Route::put('/{id}/altera', 'SaleController@update');
        Route::get('/{id}/remover', 'SaleController@destroy');
        Route::get('/{id}/removerItem/{item}', 'SaleController@removeItem');
        Route::get('/removidos', 'SaleController@archive');
        Route::get('/{id}/restaurar', 'SaleController@restory');
        Route::get('/relatorio', 'ReportController@index');
    });
});
