<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/getBots', 'BotController@getBots'); //Get all user bots
    Route::post('/addNewBot', 'BotController@addNewBot');// Ajouter un nouveau Bot


    Route::get('/getAttributes', 'DataFlowController@getAttributes');
    Route::get('/getConversations', 'BotController@getConversations');
    Route::post('/newConversation', 'BotController@newConversation');
    Route::post('/newFAQ', 'IntentController@createIntent');
    
    
    

    Route::post('/logout', 'AuthController@logout');
});


Route::post('/login', 'AuthController@login');
Route::post('/socialLogin', 'AuthController@socialLogin');

Route::post('/register', 'AuthController@register');
