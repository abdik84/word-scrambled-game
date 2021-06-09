<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'games'], function($games) {
    $games->post('/add', "GamesController@store");
    $games->get('/{player_id}', "GamesController@getGamesByPlayer");
    $games->get('/detail/{game_id}', "GamesController@getGamesDetail");
});

Route::post("/login", "AdminController@doLogin");
Route::post("/logout", "AdminController@dologout");
