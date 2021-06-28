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

Route::get('/{locale}/orientation', function () {
    // if (! in_array($locale, ['en', 'es', 'fr'])) {
    //     App::setLocale('fr');
    // }

    // App::setLocale($locale);
    return view('welcome');
});
Route::get('/{locale}', 'RoutingController@home');
Route::get('/', 'RoutingController@home');

Route::get('/{locale}/formations', 'RoutingController@pageFormation');
Route::get('/{locale}/universites', 'RoutingController@universite');
Route::get('/{locale}/etablissements', 'RoutingController@etablissement');
Route::get('/{locale}/statistiques', 'RoutingController@statistique');
Route::get('/{locale}/contact', 'RoutingController@contact');

Route::get('/testpdf', 'RoutingController@testPDFhome');

Route::get('/unauthorized', function () {
    return response()->json('Non autorisé!', 401);
})->name('unauthorized');
// Route::get('/', function () {
//    return view('home');
// });



