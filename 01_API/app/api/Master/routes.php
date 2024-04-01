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
$namespace = 'App\api\Master\Controllers';

//Master api
Route::group([
    'module' => 'Auth',
    'prefix' => 'api/master',
    'namespace' => $namespace,
    'middleware' => ['is_valid_request', 'auth:api'],
], function () {
    Route::apiResource('m005', 'M005Controller');
    Route::get('m005/data/suggest', 'M005Controller@suggestSearch')->name('m005.suggestSearch');

    Route::apiResource('m004', 'M004Controller');
    Route::get('m004/data/init', 'M004Controller@getInitData')->name('m004.getInitData');
    Route::get('m004/data/suggest', 'M004Controller@suggestSearch')->name('m004.suggestSearch');

    Route::apiResource('m006', 'M006Controller');
    Route::get('m006/data/init', 'M006Controller@getInitData')->name('m006.getInitData');
    Route::get('m006/data/suggest', 'M006Controller@suggestSearch')->name('m006.suggestSearch');

    Route::apiResource('m101', 'M101Controller');
    Route::get('m101/data/init', 'M101Controller@getInitData')->name('m101.getInitData');
    Route::get('m101/data/refer/{id}', 'M101Controller@refer')->name('m101.refer');
    Route::get('m101/data/suggest', 'M101Controller@suggestSearch')->name('m101.suggestSearch');

    Route::apiResource('m202', 'M202Controller')->only(['index', 'store', 'destroy']);

    Route::apiResource('m301', 'M301Controller')->only(['index', 'store', 'destroy']);
    Route::get('m301/data/init', 'M301Controller@getInitData')->name('m301.getInitData');

    Route::apiResource('m302', 'M302Controller')->only(['index', 'store', 'destroy']);
    Route::get('m302/data/init', 'M302Controller@getInitData')->name('m302.getInitData');
    //M201
    Route::apiResource('m201', 'M201Controller')->only(['index', 'store', 'destroy']);
    Route::get('m201/data/init', 'M201Controller@getInitData')->name('m201.getInitData');
});
