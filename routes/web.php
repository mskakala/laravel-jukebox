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
    return view('welcome');
});

// Songs
Route::get('/songs', 'SongController@listing');
Route::post('/songs', 'SongController@delete');
Route::get('/songs/create', 'SongController@create');
Route::post('/songs/create', 'SongController@store');
Route::get('/songs/edit', 'SongController@edit');
Route::post('/songs/edit', 'SongController@store');

// Authors
Route::get('/authors', 'AuthorController@listing');
Route::get('/authors/create', 'AuthorController@create');
Route::post('/authors/create', 'AuthorController@store');
Route::get('/authors/edit', 'AuthorController@edit');
Route::post('/authors/edit', 'AuthorController@store');


