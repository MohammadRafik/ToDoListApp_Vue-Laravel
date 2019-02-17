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

Route::get('/', 'TaskDataController@loadHomePage');


Auth::routes();

Route::get('/profile', 'HomeController@index')->name('profile');



Route::post('/createNewTask', 'TaskDataController@create');
Route::get('/getAllTasks', 'TaskDataController@getAllTasks');
Route::post('/updateTaskData', 'TaskDataController@updateTaskData');
Route::post('/deleteCurrentTask', 'TaskDataController@deleteTask');



Route::get('/about', function(){
    return view('footerLinks/about');
});
Route::get('/contact', function(){
    return view('footerLinks/contactus');
});
Route::get('/support', function(){
    return view('footerLinks/support');
});