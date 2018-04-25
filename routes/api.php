<?php


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
Route::name('api.')->prefix('v1')->namespace('API\V1')->group(function () {
    Route::get('/', function () {
        return response()->jsend(['It Works'], trans('api.success'));
    })->name('index');
    Route::middleware('jwt_auth')->get('/protected', function () {
        return response()->jsend(['hero protected'], trans('api.success'));
    })->name('protected');

    /**
     * Auth Related Routes
     */
    Route::name('auth.')->prefix('auth')->namespace('Auth')->group(function () {
        // JWT Routes.
        Route::name('jwt.')->prefix('jwt')->group(function () {
            Route::post('token', 'AuthenticationController@token')->name('token');
            Route::middleware('jwt_refresh')->post('refresh', 'AuthenticationController@refresh')->name('refresh');
            Route::middleware('jwt_auth')->get('logout', 'AuthenticationController@logout')->name('logout');
            Route::middleware('jwt_auth')->get('user', 'AuthenticationController@user')->name('user');
        });
    });
});
