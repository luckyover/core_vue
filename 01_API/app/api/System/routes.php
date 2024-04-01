<?php

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
$namespace = 'App\api\System\Controllers';

Route::group([
    'module' => 'Auth',
    'prefix' => 'api/system',
    'namespace' => $namespace,
    'middleware' => ['is_valid_request'],
], function () {
    // Login
    Route::post('login', 'LoginController@login')->name('login.login');
    Route::group([
        'middleware' => ['auth:api'],
    ], function () {
        Route::apiResource('m002', 'M002Controller');
        Route::get('m002/data/init', 'M002Controller@getInitData')->name('m002.getInitData');
        Route::get('m002/data/suggest', 'M002Controller@suggestSearch')->name('m002.suggestSearch');
    });
});
