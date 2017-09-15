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
Route::post('password/change', 'UserController@changePassword')->middleware('auth');

// Github Auth Route
Route::group(['prefix' => 'auth/github', 'namespace' => 'Auth'], function() {
    Route::get('/', 'AuthController@redirectToProvider');
    Route::get('callback', 'AuthController@handleProviderCallback');
    Route::get('register', 'AuthController@create');
    Route::post('register', 'AuthController@store');
});

// User
Route::group(['prefix' => 'user', 'middleware' => 'auth'], function() {
    Route::get('profile', 'UserController@edit');
    Route::put('profile/{id}', 'UserController@update');
    Route::group(['prefix' => '{username}'], function() {
        Route::get('/', 'UserController@show');
        Route::get('comments', 'UserController@comments');
    });
});

// User Setting
Route::group(['middleware' => 'auth', 'prefix' => 'setting'], function() {
    Route::get('/', 'SettingController@index')->name('setting.index');
    Route::get('binding', 'SettingController@binding')->name('setting.binding');
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

// Dashboard Index
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'admin']], function() {
    Route::get('{path?}', 'HomeController@dashboard')->where('path', '[\/\w\.-]*');
});

// Article
Route::get('/', 'ArticleController@index');
Route::get('{slug}', 'ArticleController@show');
