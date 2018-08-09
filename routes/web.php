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
Route::group(['prefix' => 'data'], function()
{
	Route::get('/prov', 'dataController@getProv')->name('prov');
	Route::get('/kab/{id_prov}', 'dataController@getKab')->name('kab');
	Route::get('/kec/{id_kab}', 'dataController@getKec')->name('kec');
	Route::get('/kel/{id_kec}', 'dataController@getKel')->name('kel');
	Route::get('/tps/{id_kel}', 'dataController@getTps')->name('tps');
	Route::get('/dapil', 'dataController@getDapil')->name('dapil');
	Route::get('/partai', 'dataController@getPartai')->name('partai');
});

/*
|----------------------------------------------------------------------
| Web Routes for admin
|----------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function()
{
	Route::get('/', function() {
    	return View::make('admin.home.index');
	});
	Route::get('/listsaksi', 'adminController@getAllSaksi')->name('list.saksi');
	Route::get('/edit/saksi/{nik}/{id}', 'adminController@editSaksi')->name('edit.saksi');
	Route::get('/view/saksi/{nik}/{id}', 'adminController@viewSaksi')->name('view.saksi');
	Route::delete('/delete/saksi/{nik}/{id}', 'adminController@deleteSaksi')->name('delete.saksi');
	Route::get('/register/saksi', 'adminController@registerSaksi')->name('register.saksi');
	Route::post('/saksi/registerPost', 'adminController@registerSaksiPost')->name('register.saksi');
	Route::post('/saksi/updateSaksiProfile', 'adminController@updateSaksiProfile')->name('update.saksi.profile');

	Route::get('/register/caleg', 'adminController@registerCaleg')->name('register.caleg');
	Route::get('/listcaleg', 'adminController@getAllCaleg')->name('list.caleg');
	Route::get('/edit/caleg/{id}', 'adminController@editCaleg')->name('edit.caleg');
	Route::get('/view/caleg/{id}', 'adminController@viewCaleg')->name('view.caleg');
	Route::delete('/delete/caleg/{id}', 'adminController@deleteCaleg')->name('delete.caleg');
	Route::post('/caleg/updateCalegProfile', 'adminController@updateCalegProfile')->name('update.caleg.profile');
	Route::post('/caleg/registerPost', 'adminController@registerPostCaleg')->name('register.post.caleg');

	Route::post('/updateProfile', 'adminController@updateProfile')->name('update.profile');
	Route::get('/login', 'adminController@login')->name('login.admin');
	Route::get('/register', 'adminController@register')->name('register.admin');
	Route::post('/registerPost', 'adminController@registerPost')->name('register.post.admin');
	Route::get('/logout', 'adminController@logout')->name('logout.admin');
	Route::post('/loginPost', 'adminController@loginPost')->name('login.post.admin');
});
