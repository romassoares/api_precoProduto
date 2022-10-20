 <?php

    use App\Http\Controllers\HomeController;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();
// Route::middleware('auth')->group(function () {
//     Route::get('/home', 'HomeController@index')->name('home');

//     // produto
//     Route::group(['prefix' => '/produto'], function () {
//         Route::get('', 'ProductController@index')->name('produto');
//         Route::get('/novo', 'ProductController@create')->name('produto.create');
//         Route::post('/salvar', 'ProductController@store')->name('produto.store');
//         Route::get('/{id}/exibir', 'ProductController@show')->name('produto.show');
//         Route::get('/{id}/editar', 'ProductController@edit')->name('produto.edit');
//         Route::put('/{id}/alterar', 'ProductController@update')->name('produto.update');
//         Route::get('/{id}/remover', 'ProductController@destroy')->name('produto.remove');
//         Route::get('/removidos', 'ProductController@archive')->name('produto.archive');
//         Route::get('/{id}/restaurar', 'ProductController@restory')->name('produto.restory');
//     });

//     // Ingredient
//     Route::group(['prefix' => '/ingrediente'], function () {
//         Route::get('', 'IngredientController@index')->name('ingrediente');
//         Route::get('/novo', 'IngredientController@create')->name('ingrediente.create');
//         Route::post('/salvar', 'IngredientController@store')->name('ingrediente.store');
//         Route::get('/{id}/exibir', 'IngredientController@show')->name('ingrediente.show');
//         Route::get('/{id}/editar', 'IngredientController@edit')->name('ingrediente.edit');
//         Route::put('/{id}/altera', 'IngredientController@update')->name('ingrediente.update');
//         Route::get('/{id}/remover', 'IngredientController@destroy')->name('ingrediente.remove');
//         Route::get('/removidos', 'IngredientController@archive')->name('ingrediente.archive');
//         Route::get('/{id}/restaurar', 'IngredientController@restory')->name('ingrediente.restory');
//     });

//     // IngredientProduto
//     Route::put('produto/{id}/altera-ingredient', 'ProductIngredientsController@update')->name('produtoIngrediente.update');
//     Route::get('produto/{id}/remove-ingredient/{ing}', 'ProductIngredientsController@remove')->name('produtoIngrediente.remove');
//     Route::put('produto/{id}/restaura-ingredient', 'ProductIngredientsController@restore')->name('produtoIngrediente.restore');
//     Route::get('/{id}/quantidade-ingrediente/{ing}', 'ProductIngredientsController@Qnt')->name('proIngQnt.qnt');
//     Route::put('produto/{id}/qnt', 'ProductIngredientsController@addQnt')->name('produtoIngrediente.addQnt');

//     Route::get('/relatorio', 'ReportController@index')->name('relatorio');

//     // cliente
//     Route::group(['prefix' => '/cliente'], function () {
//         Route::get('', 'ClientController@index')->name('cliente');
//         Route::post('/pesquisar', 'ClientController@search')->name('cliente.search');
//         Route::get('/novo', 'ClientController@create')->name('cliente.create');
//         Route::post('/salvar', 'ClientController@store')->name('cliente.store');
//         Route::get('/{id}/editar', 'ClientController@edit')->name('cliente.edit');
//         Route::put('/{id}/altera', 'ClientController@update')->name('cliente.update');
//         Route::get('/{id}/remover', 'ClientController@destroy')->name('cliente.remove');
//         Route::get('/removidos', 'ClientController@archive')->name('cliente.archive');
//         Route::get('/{id}/restaurar', 'ClientController@restory')->name('cliente.restory');
//         Route::get('/{id}/relatorio', 'ClientController@report')->name('cliente.report');
//     });

//     // venda
//     Route::group(['prefix' => '/venda'], function () {
//         Route::get('', 'SaleController@index')->name('venda');
//         Route::put('/{id}/add-product', 'SaleController@addProduct')->name('venda.addProduct');
//         Route::post('/nova-venda', 'SaleController@store')->name('venda.store');
//         Route::get('/{id}/exibir', 'SaleController@show')->name('venda.show');
//         Route::get('/{id}/editar', 'SaleController@edit')->name('venda.edit');
//         Route::put('/{id}/altera', 'SaleController@update')->name('venda.update');
//         Route::get('/{id}/remover', 'SaleController@destroy')->name('venda.remove');
//         Route::get('/{id}/removerItem/{item}', 'SaleController@removeItem')->name('venda.removeItem');
//         Route::get('/removidos', 'SaleController@archive')->name('venda.archive');
//         Route::get('/{id}/restaurar', 'SaleController@restory')->name('venda.restory');
//         Route::get('/relatorio', 'ReportController@index')->name('venda.report');
//     });
// }); 
