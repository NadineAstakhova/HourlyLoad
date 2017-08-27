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

use HoursLoad\Professors;

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/login', 'Controller@login');
Route::post('auth/login', 'Controller@authenticate');
Route::get('auth/logout', 'Controller@logout');


Route::get('hello/{prof}', 'LoadController@show');

Route::get('/prof','LoadController@index')->middleware('auth');

Route::get('/subjects','LoadController@show')->middleware('auth');

Route::get('/subjects/{idProf}','LoadController@showSub')->middleware('auth');
Route::post('/subjects/{idProf}','LoadController@showSub')->middleware('auth');

Route::get('/profile/{idProf}','LoadController@showProf')->middleware('auth');

Route::get('/addform/{idProf}/{idSub}','LoadController@addForm')->middleware('auth');

Route::post('/updateLoad/{idProf}', 'LoadController@updateLoad')->middleware('auth');

Route::get('/read', function() {
    $professors = new Professors();
    
    $data = $professors->all(array('firstName','lastName'));

    foreach ($data as $list) {
        echo $list->firstName . ' ' . $list->lastName . '';
    }
});
Auth::routes();

