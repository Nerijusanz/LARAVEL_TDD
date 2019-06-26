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

Route::get('/books','BooksController@index');
Route::post('/books','BooksController@store');
Route::put('/books/{book}','BooksController@update');
Route::delete('/books/{book}','BooksController@destroy');


Route::get('/authors','AuthorsController@index');
Route::post('/authors','AuthorsController@store');
Route::put('/authors/{author}','AuthorsController@update');
Route::delete('/authors/{author}','AuthorsController@destroy');
