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

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::resource('sponsor', 'SponsorController' );

Route::get('team/register_user/{id}', 'TeamController@register_user');
Route::get('team/deregister_user/{id}', 'TeamController@deregister_user');
Route::resource('team', 'TeamController' );

Route::get('tournament/register_judge/{id}', 'TournamentController@register_judge');
Route::get('tournament/register_user/{id}', 'TournamentController@register_user');
Route::get('tournament/deregister_user/{id}', 'TournamentController@deregister_user');
Route::post('tournament/register_team/{id}', 'TournamentController@register_team');
Route::get('tournament/deregister_team/{id}/{id_team}', 'TournamentController@deregister_team');
Route::get('tournament/deregister_jineho_ucastnika/{id}/{id_user}', 'TournamentController@deregister_jineho_ucastnika');
Route::post('tournament/update_registered', 'TournamentController@update_registered');
Route::resource('tournament', 'TournamentController' );

Route::resource('user', 'UserController' );


Route::resource('match', 'MatchController' );

Route::resource('statistic', 'StatisticController' );

Route::get('/home', 'HomeController@index')->name('home');
