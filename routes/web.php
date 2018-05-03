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

//API
Route::get('/api/events/json', 'GameController@index_json');
Route::get('/api/events/{id}/json', 'GameController@show_json');

Auth::routes();

Route::get('/resetpassword', 'Auth\ForgotPasswordController@esqueciSenha');
Route::post('/resetpassword', 'Auth\ForgotPasswordController@esqueciSenhaPost');
Route::get('/resetpassword/{remember_token}', [
    'as' => 'esqueci_senha_path',
    'uses' => 'Auth\ForgotPasswordController@esqueciSenhaConfirm'
]);
Route::post('/resetpassword', 'Auth\ForgotPasswordController@resetsenha');

Route::get('/dashboard', 'HomeController@index')->name('home');

Route::get('/markallasread', 'UserController@markallasread')->middleware('auth');

Route::get('/profile', 'UserController@profile')->middleware('auth');
Route::get('/player/{id}', 'UserController@profile_player')->middleware('auth');
Route::get('/profile/edit', 'UserController@profile_edit')->middleware('auth');
Route::post('/profile/edit', 'UserController@profile_update')->middleware('auth');
Route::get('/requests', 'UserController@requests')->middleware('auth');
Route::get('/invites', 'UserController@invites')->middleware('auth');

Route::get('/events', 'GameController@index')->middleware('auth');

Route::get('/my-events', 'GameController@myindex')->middleware('auth');
Route::get('/attending', 'GameController@attending')->middleware('auth');
Route::get('/pending', 'GameController@pending')->middleware('auth');

Route::post('/events/{id}/message/send', 'GameController@store_message')->middleware('auth');

Route::get('/events/new', 'GameController@create')->middleware('auth');
Route::post('/events/new', 'GameController@store')->middleware('auth');
Route::get('/events/{id}', 'GameController@show')->middleware('auth');
Route::get('/events/{id}/edit', 'GameController@edit')->middleware('auth');
Route::post('/events/{id}/edit', 'GameController@update')->middleware('auth');
Route::get('/events/{id}/invite', 'GameController@invite')->middleware('auth');
Route::get('/events/{id}/invite/{player_id}', 'GameController@invite_player')->middleware('auth');
Route::get('/events/{id}/join', 'GameController@join')->middleware('auth');
Route::get('/events/{id}/player/{player_id}/accept', 'GameController@accept')->middleware('auth');
Route::get('/events/{id}/player/{player_id}/reject', 'GameController@reject')->middleware('auth');
