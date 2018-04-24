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

// all the non-vue app
Route::get('/', function () {
    return view('welcome');
});

// all the vue apps.
Route::name('vue.')
    ->prefix('app')
    ->group(function () {
        Route::get('/', 'VueRedirectController')->name('index');
    });
