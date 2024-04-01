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
$namespace = 'App\Modules\Auth\Controllers';
Route::group(
    ['namespace' => $namespace, 'prefix' => '', 'middleware' => ['web', 'app_state']],
    function () {
        Route::get('login', 'LoginController@index')->name('login.index');
        Route::post('login', 'LoginController@store')->name('login.store');
    }
);
