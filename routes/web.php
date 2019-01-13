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
Route::post('/updateTaskData', 'taskDataController@updateTaskData');
Route::post('/deleteCurrentTask', 'taskDataController@deleteTask');