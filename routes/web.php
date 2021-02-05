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


//private routes liga
Route::get('/liga/dashboard', 'LeagueController@dashboard')->name('liga-dashboard')->middleware(['auth', 'verifyLeague']);
Route::get('/liga/me', 'LeagueController@me')->name('liga-me')->middleware(['auth', 'verifyLeague']);
Route::get('/liga/me/edit', 'LeagueController@meEditForm')->name('liga-me-edit-form')->middleware(['auth', 'verifyLeague']);

Route::get('/liga/post/create', 'PostsController@form')->name('liga-post-form')->middleware(['auth', 'verifyLeague']);
Route::post('/liga/post/create', 'PostsController@create')->name('liga-post-create')->middleware(['auth', 'verifyLeague']);

Route::get('/liga/post/{id}/edit', 'PostsController@editForm')->name('liga-post-edit-form')->middleware(['auth', 'verifyLeague']);
Route::post('/liga/post/{id}/edit', 'PostsController@update')->name('liga-post-edit')->middleware(['auth', 'verifyLeague']);
Route::post('/liga/post/delete', 'PostsController@delete')->name('liga-post-delete')->middleware(['auth', 'verifyLeague']);
Route::get('/liga/post/all', 'PostsController@all')->name('liga-post-all')->middleware(['auth', 'verifyLeague']);


Route::get('/liga/membros', 'LeagueController@showMembers')->name('liga-membros-all')->middleware(['auth', 'verifyLeague']);

Route::get('/liga/membros/invites', 'LeagueProfilesController@showInvites')->name('liga-members-show-invites')->middleware(['auth', 'verifyLeague']);
Route::post('/liga/membros/invites', 'LeagueProfilesController@create')->name('liga-members-create-invites')->middleware(['auth', 'verifyLeague']);

Route::get('/liga/eventos', 'EventController@allLeague')->name('liga-eventos')->middleware(['auth', 'verifyLeague']);
Route::get('/liga/evento/{id}', 'EventController@showLeague')->name('liga-evento-show')->middleware(['auth', 'verifyLeague']);
Route::get('/liga/eventos/aberto', 'EventController@open')->name('liga-eventos-aberto')->middleware(['auth', 'verifyLeague']);
Route::get('/liga/eventos/planejados', 'EventController@planned')->name('liga-eventos-planejados')->middleware(['auth', 'verifyLeague']);



Route::get('/liga/eventos/create', 'EventController@createForm')->name('liga-eventos-form')->middleware(['auth', 'verifyLeague']);
Route::post('/liga/eventos/create', 'EventController@create')->name('liga-eventos-post')->middleware(['auth', 'verifyLeague']);


Route::get('/liga/teams', 'LeagueTeamsController@show')->name('liga-times-show')->middleware(['auth', 'verifyLeague']);
Route::get('/liga/teams/invites', 'LeagueTeamsController@showInvites')->name('liga-times-show-invites')->middleware(['auth', 'verifyLeague']);
Route::post('/liga/teams/invites', 'LeagueTeamsController@create')->name('liga-times-create-invite')->middleware(['auth', 'verifyLeague']);



//private routes membro

Route::get('membro/dashboard','MemberController@dashboard')->name('membro-dashboard')->middleware(['auth','verifyMember']);
Route::get('/membro/criar', 'MemberController@createView')->name('criarProfileView')->middleware(['auth', 'verifyMember']);
Route::post('/membro/criar', 'MemberController@create')->name('criarProfile')->middleware(['auth', 'verifyMember']);

Route::get('/membro/me', 'MemberController@me')->name('membro-me')->middleware(['auth', 'verifyMember']);
Route::get('/membro/me/edit', 'MemberController@editForm')->name('membro-me-edit-form')->middleware(['auth', 'verifyMember']);
Route::post('/membro/me/edit', 'MemberController@update')->name('membro-me-edit-post')->middleware(['auth', 'verifyMember']);

Route::post('/membro/me/weapons/create', 'WeaponsController@create')->name('membro-me-weapon-post')->middleware(['auth', 'verifyMember']);
Route::get('/membro/me/weapons/all', 'WeaponsController@editForm')->name('membro-me-weapon-all')->middleware(['auth', 'verifyMember']);
Route::post('/membro/me/weapons/delete', 'WeaponsController@delete')->name('membro-me-weapon-delete')->middleware(['auth', 'verifyMember']);


// Rotas para o time
Route::get('/membro/time/criar', 'TeamController@showCreate')->name('membro-criar-time-form')->middleware(['auth', 'verifyMember']);
Route::post('/membro/time/criar', 'TeamController@create')->name('membro-criar-time-post')->middleware(['auth', 'verifyMember']);
Route::get('/membro/time/{slug}', 'TeamController@show')->name('membro-time-show')->middleware(['auth', 'verifyMember']);
Route::get('/membro/time/{slug}/edit', 'TeamController@editForm')->name('membro-time-edit-form')->middleware(['auth', 'verifyMember']);
Route::post('/membro/time/{slug}/edit', 'TeamController@edit')->name('membro-time-edit-post')->middleware(['auth', 'verifyMember']);
Route::get('/membro/time/{slug}/member/edit/{id}', 'TeamController@memberEdit')->name('membro-time-edit-member-form')->middleware(['auth', 'verifyMember']);
Route::post('/membro/time/{slug}/member/edit/{id}', 'TeamController@memberUpdate')->name('membro-time-edit-member-post')->middleware(['auth', 'verifyMember']);


Route::get('/membro/league/posts', 'LeagueController@showPostsMember')->name('membro-league-show-posts')->middleware(['auth', 'verifyMember']);
Route::get('/membro/league/events', 'LeagueController@showEventsMember')->name('membro-league-show-events')->middleware(['auth', 'verifyMember']);
Route::get('/membro/league/events/{id}', 'EventController@show')->name('membro-league-show-event')->middleware(['auth', 'verifyMember']);



Route::post('/membro/time/{slug}/league', 'TeamController@invitePost')->name('membro-time-invite-post')->middleware(['auth', 'verifyMember']);
