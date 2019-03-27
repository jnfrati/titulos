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

Auth::routes();

Route::get('/', 'HomeController@showTitulos');


Route::get('/home', 'HomeController@showTitulos')->name('home');

Route::get('/log', 'HomeController@log');

//Titulo
Route::get('/titulo/edit/{id}', 'HomeController@showTitulo');

Route::get('/titulo/create', 'HomeController@createTitulo');


Route::post('/titulo/create', 'TituloController@create');

Route::post('/titulo/edit/{id}', 'TituloController@edit');

Route::post('/titulo/print/{id}', 'TituloController@print');

Route::post('/titulo/close/{id}','TituloController@close');

Route::post('/titulo/finalize/{id}','TituloController@finalize');

Route::delete('/titulo/delete/{id}', 'TituloController@delete');

Route::post('/titulo/restaurar/{id}', 'TituloController@restore');

//Carrera
Route::get('/carrera/show','HomeController@showCarreras');

Route::get('/carrera/show/{id}','HomeController@showCarrera');

Route::post('/carrera/show/{id}','HomeController@showCarrera');

Route::post('/carrera/create', 'CarreraController@create');

Route::post('/carrera/edit', 'CarreraController@edit');

Route::delete('/carrera/delete/{id}','CarreraController@delete');

//Users

Route::get('/users/list', 'HomeController@listUsers');

Route::get('/users/list/{id}', 'HomeController@editUser');

Route::post('/users/edit','UserController@editUser');

Route::patch('/users/restore','UserController@restoreUser');

Route::delete('/users/delete/{id}', 'UserController@deleteUser');
