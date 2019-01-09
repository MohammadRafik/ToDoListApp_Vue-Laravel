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

Route::get('/', function () {
    return view('FrontPage');
});

Auth::routes();

Route::get('/profile', 'HomeController@index')->name('profile');
Route::get('/edit', function(){
    return 'pepega 123';
});