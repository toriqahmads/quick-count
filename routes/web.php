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
})->middleware('auth:admin,saksi');


/*
|----------------------------------------------------------------------
| Web Routes for getting data
|----------------------------------------------------------------------
*/
Route::group(['prefix' => 'data'], function()
{
	Route::get('/prov', 'dataController@getProv')->name('prov');
	Route::get('/provid/{id}', 'dataController@getProvById')->name('provid');
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
	Route::get('/calegdpd/{prov}/{id_partai}/{tingkat}', 'dataController@getCalegDpd')->name('caleg.dpd');
	Route::get('/getpres/{id_partai}/{tingkat}', 'dataController@getAllPres')->name('pres');
});

/*
|----------------------------------------------------------------------
| Web Routes for admin
|----------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function()
{
	Route::get('/login', 'Auth\AdminLoginController@login')->name('login.admin');
	Route::post('/loginPost', 'Auth\AdminLoginController@loginPost')->name('login.post.admin');
	Route::group(['middleware' => ['auth:admin', 'role:admin']], function()
	{
		Route::get('/', 'adminController@index')->name('index.admin');
		Route::post('/updateProfile', 'adminController@updateProfile')->name('update.profile');
		Route::get('/register', 'adminController@register')->name('register.admin');
		Route::post('/registerPost', 'adminController@registerPost')->name('register.post.admin');
		Route::get('/logout', 'Auth\AdminLoginController@logout')->name('logout.admin');
	});
});

Route::group(['prefix' => 'saksi'], function()
{
	Route::post('/loginPost', 'Auth\SaksiLoginController@loginPost')->name('login.post.saksi');
	Route::get('/login', 'Auth\SaksiLoginController@login')->name('login.saksi');
	Route::group(['middleware' => ['auth:saksi', 'role:saksi']], function()
	{
		Route::get('/', 'saksiController@index')->name('index.saksi');
		Route::get('/editProfile', 'saksiController@editProfile')->name('edit.profile.saksi');
		Route::get('/logout', 'Auth\SaksiLoginController@logout')->name('logout.saksi');
	});
	
	Route::group(['middleware' => ['auth:admin,saksi', 'role:admin,saksi']], function()
	{
		Route::post('/updateSaksiProfile', 'saksiController@updateSaksiProfile')->name('update.saksi.profile');
	});

	Route::group(['middleware' => ['auth:admin', 'role:admin']], function()
	{
		Route::get('/listsaksi', 'saksiController@getAllSaksi')->name('list.saksi');
		Route::get('/edit/{nik}/{id}', 'saksiController@editSaksi')->name('edit.saksi');
		Route::get('/view/{nik}/{id}', 'saksiController@viewSaksi')->name('view.saksi');
		Route::delete('/delete/{nik}/{id}', 'saksiController@deleteSaksi')->name('delete.saksi');
		Route::get('/register', 'saksiController@registerSaksi')->name('register.saksi');
		Route::post('/registerPost', 'saksiController@registerSaksiPost')->name('register.saksi');
	});
});

Route::group(['prefix' => 'caleg'], function()
{
	Route::group(['middleware' => ['auth:admin', 'role:admin']], function()
	{
		Route::get('/register', 'calegController@registerCaleg')->name('register.caleg');
		Route::get('/listcaleg/{tingkat?}', 'calegController@getAllCaleg')->name('list.caleg');
		Route::get('/edit/{id}', 'calegController@editCaleg')->name('edit.caleg');
		Route::get('/view/{id}', 'calegController@viewCaleg')->name('view.caleg');
		Route::delete('/delete/{id}', 'calegController@deleteCaleg')->name('delete.caleg');
		Route::post('/updateCalegProfile', 'calegController@updateCalegProfile')->name('update.caleg.profile');
		Route::post('/registerPost', 'calegController@registerPostCaleg')->name('register.post.caleg');
	});
});

Route::group(['prefix' => 'partai'], function()
{
	Route::group(['middleware' => ['auth:admin', 'role:admin']], function()
	{
		Route::get('/register', 'partaiController@registerPartai')->name('register.partai');
		Route::get('/listpartai', 'partaiController@getAllPartai')->name('list.partai');
		Route::get('/edit/{id}', 'partaiController@editPartai')->name('edit.partai');
		Route::get('/view/{id}', 'partaiController@viewPartai')->name('view.partai');
		Route::delete('/delete/{id}', 'partaiController@deletePartai')->name('delete.partai');
		Route::post('/updatePartai', 'partaiController@updatePartai')->name('update.partai');
		Route::post('/registerPost', 'partaiController@registerPostPartai')->name('register.post.partai');
	});
});

Route::group(['prefix' => 'tps'], function()
{
	Route::group(['middleware' => ['auth:admin', 'role:admin']], function()
	{
		Route::get('/register', 'tpsController@registerTps')->name('register.tps');
		Route::get('/listtps', 'tpsController@getAllTps')->name('list.tps');
		Route::get('/edit/{id}', 'tpsController@editTps')->name('edit.tps');
		Route::get('/view/{id}', 'tpsController@viewTps')->name('view.tps');
		Route::delete('/delete/{id}', 'tpsController@deleteTps')->name('delete.tps');
		Route::post('/updateTPS', 'tpsController@updateTps')->name('update.tps');
		Route::post('/registerPost', 'tpsController@registerPostTps')->name('register.post.tps');
	});
});

Route::group(['prefix' => 'suara'], function()
{
	Route::group(['middleware' => ['auth:admin,saksi', 'role:admin,saksi']], function()
	{
		Route::get('/register', 'suaraController@registerSuara')->name('register.suara');
		Route::get('/register/dprkab', 'suaraController@registerDprKab')->name('register.dprkab');
		Route::get('/register/dprprov', 'suaraController@registerDprProv')->name('register.dprprov');
		Route::get('/register/dprri', 'suaraController@registerDprRi')->name('register.dprri');
		Route::get('/register/dpd', 'suaraController@registerDpd')->name('register.dpd');
		Route::get('/register/presiden', 'suaraController@registerPres')->name('register.presiden');
		Route::post('/registerForm', 'suaraController@registerForm')->name('register.form');
		Route::post('/view', 'suaraController@viewSuara')->name('view.suara');
		Route::post('/viewForm', 'suaraController@viewForm')->name('view.form');
		Route::get('/view/dprkab', 'suaraController@viewDprKab')->name('view.dprkab');
		Route::get('/view/dprprov', 'suaraController@viewDprProv')->name('view.dprprov');
		Route::get('/view/dprri', 'suaraController@viewDprRi')->name('view.dprri');
		Route::get('/view/dpd', 'suaraController@viewDpd')->name('view.dpd');
		Route::get('/view/presiden', 'suaraController@viewPres')->name('view.presiden');

		Route::get('/suarapartaibysaksi/{id_partai}/{id_tps}/{id_saksi}/{tingkat}', 'suaraController@getAllSuaraPartaiBySaksi')->name('suarapartaisaksi');
		Route::get('/suaracalegbysaksi/{id_partai}/{id_tps}/{id_saksi}/{tingkat}', 'suaraController@getAllSuaraCalegBySaksi')->name('suaracalegsaksi');
		Route::get('/view', 'suaraController@viewSuara')->name('view.suara');
		Route::delete('/delete', 'suaraController@deleteSuara')->name('delete.suara');
		Route::post('/updateSuara', 'suaraController@updateSuara')->name('update.suara');
		Route::post('/registerPostSuara', 'suaraController@registerPostSuara')->name('register.post.suara');
	});

	Route::group(['middleware' => ['auth:admin', 'role:admin']], function()
	{
		Route::get('/suarapartai/{id_partai}/{id_tps}/{tingkat}', 'suaraController@getAllSuaraPartai')->name('suarapartai');

		Route::get('/suaracaleg/{id_partai}/{id_tps}/{tingkat}', 'suaraController@getAllSuaraCaleg')->name('suarapartai');
	});
});

Route::group(['prefix' => 'tabulasi'], function()
{
	Route::group(['middleware' => ['auth:admin', 'role:admin']], function()
	{
		Route::get('/view', 'tabulasiController@tabulasi')->name('tabulasi');
		Route::get('/tabulasi/{tingkat}/{jenis}', 'tabulasiController@viewTabulasi')->name('view.tabulasi');
		Route::post('/viewForm', 'tabulasiController@viewForm')->name('tabulasi.form');

		Route::get('/partai/tps/{tps}/{tingkat}', 'tabulasiController@tabulasiPartaiByTps')->name('partai.tps');
		Route::get('/partai/kel/{kel}/{tingkat}', 'tabulasiController@tabulasiPartaiByKel')->name('partai.kel');
		Route::get('/partai/kec/{kec}/{tingkat}', 'tabulasiController@tabulasiPartaiByKec')->name('partai.kec');
		Route::get('/partai/kab/{kab}/{tingkat}', 'tabulasiController@tabulasiPartaiByKab')->name('partai.kab');
		Route::get('/partai/prov/{prov}/{tingkat}', 'tabulasiController@tabulasiPartaiByProv')->name('partai.prov');
		Route::get('/partai/dapil/{dapil}/{tingkat}', 'tabulasiController@tabulasiPartaiByDapil')->name('partai.dapil');

		Route::get('/caleg/tps/{partai}/{tps}/{tingkat}', 'tabulasiController@tabulasiCalegByTps')->name('caleg.tps');
		Route::get('/caleg/kel/{partai}/{kel}/{tingkat}', 'tabulasiController@tabulasiCalegByKel')->name('caleg.kel');
		Route::get('/caleg/kec/{partai}/{kec}/{tingkat}', 'tabulasiController@tabulasiCalegByKec')->name('caleg.kec');
		Route::get('/caleg/kab/{partai}/{kab}/{tingkat}', 'tabulasiController@tabulasiCalegByKab')->name('caleg.kab');
		Route::get('/caleg/prov/{partai}/{prov}/{tingkat}', 'tabulasiController@tabulasiCalegByProv')->name('caleg.prov');
		Route::get('/caleg/dapil/{partai}/{dapil}/{tingkat}', 'tabulasiController@tabulasiCalegByDapil')->name('caleg.dapil');
	});
});