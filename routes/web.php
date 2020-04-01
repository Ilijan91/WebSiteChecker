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
Route::get('/', 'ProjectsController@index');

Auth::routes();

Route::resource('projects','ProjectsController');



Route::get('/urls/{id}/create', 'UrlsController@create');
Route::get('/urls/{id}/show', 'UrlsController@show');
Route::get('/urls/{id}/edit', 'UrlsController@edit');
Route::resource('urls','UrlsController');

Route::get('/home', 'HomeController@index');
Route::get('/settings', 'HomeController@editSettings');
Route::put('/users/{id}','HomeController@update');

Route::get('markAsRead', function(){
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('markRead');