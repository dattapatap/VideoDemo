<?php

use Illuminate\Support\Facades\Route;

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
    return view('index');
});

Auth::routes();
Route::get('/admin', 'AdminController@index')->name('admin')->middleware('admin');
Route::get('/user', 'UserController@index')->name('user')->middleware('user');

Route::get('/users', 'UserController@getAllUser');
Route::get('/useradd', 'AdminController@getUserForm');
Route::post('/addNewUser', 'AdminController@store');
Route::get('/deleteUser/{id}', 'AdminController@deleteUser');

Route::get('/videoList', 'VideoController@getAllVideo');
Route::get('/videoadd', 'VideoController@getVideoForm');
Route::post('/addNewVideo', 'VideoController@store');
Route::get('/deleteVideo/{id}', 'VideoController@deleteVideo');
