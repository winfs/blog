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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function($api) {
    $api->group(['middleware' => ['api.auth', 'admin'], 'namespace' => 'App\Http\Controllers\Api'], function($api) {
        // User
        $api->get('user/{id}/edit', 'UserController@edit');
        $api->post('user/{id}/status', 'UserController@status');
        $api->resource('user', 'UserController', ['except' => ['show']]);

        // Article
        $api->get('article/{id}/edit', 'ArticleController@edit')->name('api.article.edit');
        $api->resource('article', 'ArticleController', [
            'except' => ['show'],
            'names' => [
                'index' => 'api.article.index',
                'store' => 'api.article.store',
                'update' => 'api.article.update',
                'destroy' => 'api.article.destroy',
            ],
        ]);

        // Category
    });
});
