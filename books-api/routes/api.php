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

Route::post('register', 'Auth\AuthController@register');
Route::post('login', 'Auth\AuthController@login');

Route::group(['middleware' => 'jwt'], function() {
    Route::post('me', 'Auth\AuthController@me');
    Route::post('refresh', 'Auth\AuthController@refresh');
    Route::post('logout', 'Auth\AuthController@logout');

    Route::post('author', 'AuthorController@store');
    Route::put('author/{id}', 'AuthorController@update');
    Route::delete('author/{id}', 'AuthorController@destroy');
    
    Route::post('book', 'BookController@store');
    Route::put('book/{id}', 'BookController@update');
    Route::delete('book/{id}', 'BookController@destroy');
});

Route::get('author', 'AuthorController@index');
Route::get('author/{id}', 'AuthorController@show');

Route::get('book', 'BookController@index');
Route::get('book/{id}', 'BookController@show');