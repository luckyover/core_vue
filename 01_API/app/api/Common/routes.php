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
$namespace = 'App\api\Common\Controllers';

Route::group([
    'module' => 'Common',
    'namespace' => $namespace,
], function () {
    Route::get('export/{showName}', 'AppController@downloadFile')->name('app.showFile');
    Route::get('export', 'AppController@downloadFile')->name('app.downloadFile');
    Route::group([
        'prefix' => 'api',
        'middleware' => ['is_valid_request'],
    ], function () {
        // App
        Route::get('app/app-state', 'AppController@getAppState')->name('app.getAppState');
        Route::group([
            'middleware' => ['auth:api'],
        ], function () {
            Route::get('input-search/employee/search', 'InputSearchController@searchEmployee')->name('inputSearch.searchEmployee');
            Route::get('input-search/employee/refer', 'InputSearchController@referEmployee')->name('inputSearch.referEmployee');
        });
    });
});
