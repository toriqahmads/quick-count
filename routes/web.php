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

/*
|----------------------------------------------------------------------
| Web Routes for getting data
|----------------------------------------------------------------------
*/
Route::get('/data/prov', 'dataController@getProv');
Route::get('/data/kab/{id_prov}', 'dataController@getKab');
Route::get('/data/kec/{id_kab}', 'dataController@getKec');
Route::get('/data/kel/{id_kec}', 'dataController@getKel');
Route::get('/data/tps/{id_kel}', 'dataController@getTps');
Route::get('/data/dapil', 'dataController@getDapil');
Route::get('/data/partai', 'dataController@getPartai');


/*
|----------------------------------------------------------------------
| Web Routes for admin
|----------------------------------------------------------------------
*/

Route::get('/admin', 'adminController@index');
Route::post('/admin/updateProfile', 'adminController@updateProfile');
Route::get('/admin/login', 'adminController@login');
Route::get('/admin/register', 'adminController@register');
Route::post('/admin/registerPost', 'adminController@registerPost');
Route::get('/admin/logout', 'adminController@logout');
Route::post('/admin/loginPost', 'adminController@loginPost');