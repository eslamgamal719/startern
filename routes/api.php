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


// All Routes (API) here Must Be Authenticated
Route::group(['middleware' => 'api', 'namespace' => 'Api'], function(){

	//api/get-main-categories
	Route::post('get-main-categories', 'CategoriesController@index');

});
 