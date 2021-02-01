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
    return view('welcome');
});

Auth::routes();


Route::get('/estados', 'StateController@getEstados');
Route::get('get-cidades/{estado_id}', 'CityController@getCidades');


/** League */

Route::get('/liga/criar', 'LeagueController@createView')->name('criarligaView')->middleware(['auth', 'verifyLeague']);
Route::post('/liga/criar', 'LeagueController@create')->name('criarliga')->middleware(['auth', 'verifyLeague']);


//private routes
Route::get('/liga/dashboard', 'LeagueController@index')->name('liga-dashboard')->middleware(['auth', 'verifyLeague']);
Route::get('/liga/me', 'LeagueController@me')->name('liga-me')->middleware(['auth', 'verifyLeague']);
Route::get('/liga/me/edit', 'LeagueController@meEditForm')->name('liga-me-edit-form')->middleware(['auth', 'verifyLeague']);

Route::get('/liga/post/create', 'PostsController@form')->name('liga-post-form')->middleware(['auth', 'verifyLeague']);
Route::post('/liga/post/create', 'PostsController@create')->name('liga-post-create')->middleware(['auth', 'verifyLeague']);

Route::get('/liga/post/{id}/editar', 'PostsController@editForm')->name('liga-post-edit-form')->middleware(['auth', 'verifyLeague']);
Route::post('/liga/post/{id}/editar', 'PostsController@update')->name('liga-post-edit')->middleware(['auth', 'verifyLeague']);

Route::get('/liga/eventos', 'LeagueController@me')->name('liga-eventos')->middleware(['auth', 'verifyLeague']);
