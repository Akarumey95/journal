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

Route::get('/', 'JournalsController@index');
Route::get('/show/{id}', 'JournalsController@show')->name('show');

Route::get('/api/getJournal/', 'JournalsController@getJournal');
Route::get('/api/getJournal/{id}', 'JournalsController@getJournal');

Route::get('/admin', 'JournalsController@admin');
Route::post('/admin/journal/save', 'JournalsController@create');
Route::post('/admin/journal/delete', 'JournalsController@delete');