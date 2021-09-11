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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// JWT ROUTES
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::get('roles/{id}', 'App\Http\Controllers\AuthController@getRoles');
    Route::put('update/{id}', 'App\Http\Controllers\AuthController@update');    
});

//category
Route::get('/categories','App\Http\Controllers\CategoryController@index');
Route::get('/categories/{id_category}','App\Http\Controllers\CategoryController@show');
Route::post('/categories','App\Http\Controllers\CategoryController@store');
Route::put('/categories/{id}','App\Http\Controllers\CategoryController@update');
Route::delete('/categories/{id}','App\Http\Controllers\CategoryController@destroy');

//drink
Route::get('/drinks','App\Http\Controllers\DrinkController@index');
Route::get('/drinks/{id}','App\Http\Controllers\DrinkController@show');
Route::get('/drinks/category/{category}','App\Http\Controllers\DrinkController@getByCategory');
Route::post('/drinks','App\Http\Controllers\DrinkController@store');
Route::put('/drinks/{id}','App\Http\Controllers\DrinkController@update');
Route::delete('/drinks/{id}','App\Http\Controllers\DrinkController@destroy');

//cart
Route::get('/carts','App\Http\Controllers\CartController@index');
Route::get('/carts/{id_user}','App\Http\Controllers\CartController@show');
Route::post('/carts','App\Http\Controllers\CartController@store');
Route::put('/carts/{id_user}/{id_drink}','App\Http\Controllers\CartController@update');
Route::delete('/carts/{id_user}/{id_drink}','App\Http\Controllers\CartController@destroy');

//home
Route::get('/homes','App\Http\Controllers\HomeController@index');
Route::get('/homes/{id}','App\Http\Controllers\HomeController@show');
Route::get('/homes/{city}/{address}','App\Http\Controllers\HomeController@showByAddress');
Route::post('/homes','App\Http\Controllers\HomeController@store');
  //Do to this is an anddress I'm not adding deleting or udating methods

//purchase
Route::post('/purchases/{user_id}/{home_id}','App\Http\Controllers\PurchaseController@addPurchase');
Route::post('/purchases/{user_id}','App\Http\Controllers\PurchaseController@getPurchasesByCostumer');