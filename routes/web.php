<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// User Auth
Auth::routes();

// Github Auth Route
Route::group(['prefix' => 'auth/github', 'namespace' => 'Auth'], function() {
    Route::get('/', 'AuthController@redirectToProvider');
    Route::get('callback', 'AuthController@handleProviderCallback');
    Route::get('register', 'AuthController@create');
    Route::post('register', 'AuthController@store');
});

// Search
Route::get('search', 'HomeController@search');

// Link
Route::get('link', 'LinkController@index');

// Category
Route::group(['prefix' => 'category'], function() {
    Route::get('/', 'CategoryController@index');
    Route::get('{category}', 'CategoryController@show');
});

// Tag
Route::group(['prefix' => 'tag'], function() {
    Route::get('/', 'TagController@index');
    Route::get('{tag}', 'TagController@show');
});

// Article
Route::get('/', 'ArticleController@index');
Route::get('{slug}', 'ArticleController@show');
