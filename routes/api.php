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
    
    Route::post('/logout', 'AuthController@logout');




    //API CRUD Universites
    
    Route::post('/universites', 'UniversiteController@create');
    Route::delete('/universites/{universite}', 'UniversiteController@delete');
    Route::put('/universites/{universite}', 'UniversiteController@update');

    //API CRUD Etablissements
    
    Route::get('/etablissements/{etablissement}', 'EtablissementController@getOne');
    Route::post('/etablissements', 'EtablissementController@create');
    Route::delete('/etablissements/{etablissement}', 'EtablissementController@delete');
    Route::put('/etablissements/{etablissement}', 'EtablissementController@update');
    Route::put('/etablissements/affect/specialite/{etablissement}', 'EtablissementController@affectSpecialite');
    Route::put('/etablissements/desaffect/specialite/{etablissement}', 'EtablissementController@desaffectSpecialite');

    //API CRUD Domaines
    
    Route::post('/domaines', 'DomaineController@create');
    Route::delete('/domaines/{domaine}', 'DomaineController@delete');
    Route::put('/domaines/{domaine}', 'DomaineController@update');

    //API CRUD Mentions
    
    Route::post('/mentions', 'MentionController@create');
    Route::delete('/mentions/{mention}', 'MentionController@delete');
    Route::put('/mentions/{mention}', 'MentionController@update');
    
    //API CRUD Diplomes
    
    Route::post('/diplomes', 'DiplomeController@create');
    Route::delete('/diplomes/{diplome}', 'DiplomeController@delete');
    Route::put('/diplomes/{diplome}', 'DiplomeController@update');
    
    //API CRUD Specialites
    
    Route::post('/specialites', 'SpecialiteController@create');
    Route::delete('/specialites/{specialite}', 'SpecialiteController@delete');
    Route::put('/specialites/{specialite}', 'SpecialiteController@update');   


    //API CRUD Users
    Route::put('/updatePassword/{user}', 'UserController@updatePassword');
    Route::post('/register', 'AuthController@register');
    Route::put('/users/{user}', 'UserController@updateUser');
    Route::delete('/users/{user}', 'UserController@deleteUser');

});

Route::post('/generatePDF', 'GenerateController@pdf');
Route::post('/generateExcel', 'GenerateController@excel');
Route::post('/generateCSV', 'GenerateController@csv');





Route::post('/register', 'AuthController@register');

// Route::get('/data', 'DataController@getData');
Route::post('/login', 'AuthController@login');

Route::get('/etablissements', 'EtablissementController@get');
Route::get('/domaines', 'DomaineController@get');
Route::get('/mentions', 'MentionController@get');
Route::get('/diplomes', 'DiplomeController@get');
Route::get('/specialites', 'SpecialiteController@get');
Route::get('/universites', 'UniversiteController@get');
Route::get('/statistiques', 'StatistiqueController@get');


// Route::get('/truncateAll', 'UniversiteController@truncateAll');
