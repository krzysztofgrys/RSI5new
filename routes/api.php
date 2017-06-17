<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1', 'namespace' => 'Api\v1'], function () {
        Route::get('/books', [
            'uses' => 'LibraryController@index',
            'as' => 'v1.books'
        ]);
        Route::resource('book', 'LibraryController', ['only' => 'show']);
        Route::post('book', ['uses' => 'LibraryController@add', 'as' => 'v1.book']);
        Route::delete('book/{id}', ['uses' => 'LibraryController@delete', 'as' => 'v1.book']);
//        Route::delete('book', 'LibraryController', ['only' => 'delete']);
});