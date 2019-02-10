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
    return view('saksi.login.login');
});

/*
|----------------------------------------------------------------------
| Web Routes for getting data
|----------------------------------------------------------------------
*/
Route::group(['prefix' => 'data'], function()
{
	Route::get('/prov', 'dataController@getProv')->name('prov');
	Route::get('/kaball/', 'dataController@getAllKab')->name('kaball');
	Route::get('/kab/{id_prov}', 'dataController@getKab')->name('kab');
	Route::get('/kabid/{id_kab}', 'dataController@getKabById')->name('kabid');
	Route::get('/kec/{id_kab}', 'dataController@getKec')->name('kec');
	Route::get('/kecid/{id}', 'dataController@getKecById')->name('kecid');
	Route::get('/kel/{id_kec}', 'dataController@getKel')->name('kel');
	Route::get('/tps/{id_kel}', 'dataController@getTps')->name('tps');
	Route::get('/dapil', 'dataController@getAllDapil')->name('alldapil');
	Route::get('/dapilprov/{prov}/{jenis}', 'dataController@getDapilByProv')->name('dapilprov');
	Route::get('/dapilkab/{prov}/{kab}/{jenis}', 'dataController@getDapilByKab')->name('dapilkab');
	Route::get('/partai', 'dataController@getPartai')->name('partai');
	Route::get('/caleg/{id_dapil}/{id_partai}/{tingkat}', 'dataController@getCaleg')->name('caleg');
});

/*
|----------------------------------------------------------------------
| Web Routes for admin
|----------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function()
{
	Route::get('/', 'adminController@index');

	Route::post('/updateProfile', 'adminController@updateProfile')->name('update.profile');
	Route::get('/login', 'adminController@login')->name('login.admin');
	Route::get('/register', 'adminController@register')->name('register.admin');
	Route::post('/registerPost', 'adminController@registerPost')->name('register.post.admin');
	Route::get('/logout', 'adminController@logout')->name('logout.admin');
	Route::post('/loginPost', 'adminController@loginPost')->name('login.post.admin');
});

Route::group(['prefix' => 'saksi'], function()
{
	Route::get('/', 'saksiController@index')->name('index.saksi');
	Route::get('/editProfile', 'saksiController@editProfile')->name('edit.profile.saksi');
	Route::get('/login', 'saksiController@login')->name('login.saksi');
	Route::post('/loginPost', 'saksiController@loginPost')->name('login.post.saksi');
	Route::get('/logout', 'saksiController@logout')->name('logout.saksi');
	Route::get('/listsaksi', 'saksiController@getAllSaksi')->name('list.saksi');
	Route::get('/edit/{nik}/{id}', 'saksiController@editSaksi')->name('edit.saksi');
	Route::get('/view/{nik}/{id}', 'saksiController@viewSaksi')->name('view.saksi');
	Route::delete('/delete/{nik}/{id}', 'saksiController@deleteSaksi')->name('delete.saksi');
	Route::get('/register', 'saksiController@registerSaksi')->name('register.saksi');
	Route::post('/registerPost', 'saksiController@registerSaksiPost')->name('register.saksi');
	Route::post('/updateSaksiProfile', 'saksiController@updateSaksiProfile')->name('update.saksi.profile');
});

Route::group(['prefix' => 'caleg'], function()
{
	Route::get('/register', 'calegController@registerCaleg')->name('register.caleg');
	Route::get('/listcaleg', 'calegController@getAllCaleg')->name('list.caleg');
	Route::get('/edit/{id}', 'calegController@editCaleg')->name('edit.caleg');
	Route::get('/view/{id}', 'calegController@viewCaleg')->name('view.caleg');
	Route::delete('/delete/{id}', 'calegController@deleteCaleg')->name('delete.caleg');
	Route::post('/updateCalegProfile', 'calegController@updateCalegProfile')->name('update.caleg.profile');
	Route::post('/registerPost', 'calegController@registerPostCaleg')->name('register.post.caleg');
});

Route::group(['prefix' => 'partai'], function()
{
	Route::get('/register', 'partaiController@registerPartai')->name('register.partai');
	Route::get('/listpartai', 'partaiController@getAllPartai')->name('list.partai');
	Route::get('/edit/{id}', 'partaiController@editPartai')->name('edit.partai');
	Route::get('/view/{id}', 'partaiController@viewPartai')->name('view.partai');
	Route::delete('/delete/{id}', 'partaiController@deletePartai')->name('delete.partai');
	Route::post('/updatePartai', 'partaiController@updatePartai')->name('update.partai');
	Route::post('/registerPost', 'partaiController@registerPostPartai')->name('register.post.partai');
});

Route::group(['prefix' => 'tps'], function()
{
	Route::get('/register', 'tpsController@registerTps')->name('register.tps');
	Route::get('/listtps', 'tpsController@getAllTps')->name('list.tps');
	Route::get('/edit/{id}', 'tpsController@editTps')->name('edit.tps');
	Route::get('/view/{id}', 'tpsController@viewTps')->name('view.tps');
	Route::delete('/delete/{id}', 'tpsController@deleteTps')->name('delete.tps');
	Route::post('/updateTPS', 'tpsController@updateTps')->name('update.tps');
	Route::post('/registerPost', 'tpsController@registerPostTps')->name('register.post.tps');
});

Route::group(['prefix' => 'suara'], function()
{
	Route::get('/register', 'suaraController@registerSuara')->name('register.suara');
	Route::get('/suarapartai/{id_dapil}/{id_partai}/{id_tps}', 'suaraController@getAllSuaraPartai')->name('suarapartai');
	Route::get('/suarapartaibysaksi/{id_dapil}/{id_partai}/{id_tps}/{id_saksi}', 'suaraController@getAllSuaraPartaiBySaksi')->name('suarapartaisaksi');
	Route::get('/suarapartaibydapil/{id_dapil}/{id_partai}', 'suaraController@getAllSuaraPartaiByDapil')->name('suarapartaibydapil');

	Route::get('/suarapartaibydapilforchart/{id_dapil}', 'suaraController@getAllSuaraPartaiForChartByDapil')->name('suarapartaibydapilforchart');

	Route::get('/suarapartaibytpsforchart/{id_dapil}/{id_tps}', 'suaraController@getAllSuaraPartaiForChartByTps')->name('suarapartaibytpsforchart');

	Route::get('/suaracalegbydapil/{id_dapil}/{id_partai}', 'suaraController@getAllSuaraCalegByDapil')->name('suaracalegbydapil');
	Route::get('/suaracaleg/{id_dapil}/{id_partai}/{id_tps}', 'suaraController@getAllSuaraCaleg')->name('suarapartai');
	Route::get('/suaracalegbysaksi/{id_dapil}/{id_partai}/{id_tps}/{id_saksi}', 'suaraController@getAllSuaraCalegBySaksi')->name('suaracalegsaksi');
	Route::get('/edit/{id}', 'suaraController@editSuara')->name('edit.suara');
	Route::get('/view', 'suaraController@viewSuara')->name('view.suara');
	Route::delete('/delete', 'suaraController@deleteSuara')->name('delete.suara');
	Route::post('/updateSuara', 'suaraController@updateSuara')->name('update.suara');
	Route::post('/registerPostSuara', 'suaraController@registerPostSuara')->name('register.post.suara');
});

Route::group(['prefix' => 'tabulasi'], function()
{
	Route::get('/dapil', 'tabulasiController@tabulasiDapil')->name('tabulasi.dapil');
	Route::get('/tps', 'tabulasiController@tabulasiTps')->name('tabulasi.tps');
});