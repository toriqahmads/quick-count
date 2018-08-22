<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\adminModel;
use App\dataModel;
use App\saksiModel;
use App\calegModel;
use App\tpsModel;
use App\partaiModel;
class adminController extends Controller
{
    function index()
    {
	    if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	/*$data = new adminModel();
	    	/$data = $data->getProfile(Session::get('username'));
	    	$kecamatan = new dataModel();
	    	$kecs = $kecamatan->getKec(1);
	    	$kels = $kecamatan->getKel($data->id_kel);
	    	$tps = $kecamatan->getTps($data->id_tps);*/
            $data = Session::get('username');
	    	return view('admin.home.index', compact('data'));
	    }
    }

    function login()
    {
    	if(!empty(Session::get('login')) && Session::get('role') == 'admin')
	    {
	    	$data = new adminModel();
	    	//$data = $data->getProfile(Session::get('username'));
	    	return view('admin.home.index', compact('data'));
	    }
	    else
	    {
	    	return view('admin.login.login');
	    }
    }

    function logout()
    {
        Session::flush();
        return redirect('admin/login')->with('alert','Anda sudah logout');
    }

    function loginPost(Request $request)
    {
    	$username = $request->username;
    	$password = $request->password;
    	if(!empty($username) && !empty($password))
    	{
    		$data = new adminModel();
	    	$data = $data->cekLogin($username);
	    	
	    	if(@count($data) > 0)
	    	{
	    		if(Hash::check($password, $data->pass))
	    		{
	    			Session::put('username', $data->username);
	    			Session::put('id', $data->id);
	    			Session::put('login', true);
	    			Session::put('role', 'admin');

	    			return redirect('admin');
	   			}
	   			else
	   			{
	   				return redirect('admin/login')->with('alert', 'Maaf password yang Anda masukkan salah!');
	   			}
	    	}
	    	else
	    	{
	    		return redirect('admin/login')->with('alert', 'Maaf username yang Anda masukkan tidak terdaftar!');
	    	}
    	}
    	else
    	{
    		return redirect('admin/login')->with('alert', 'Maaf username/password harus diisi!');
    	}
    }

    function registerSaksi()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden');
	    }
	    else
	    {
	    	$data = new dataModel();
	    	$data = $data->getKec(1);
	    	return view('admin.saksi.register', compact('data'));
	    }
    }

    function registerSaksiPost(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'nik' => 'required|min:16|unique:saksi|max:16',
            'telp' => 'required|min:11|max:13',
            'gender' => 'required|min:1|max:1',
            'alamat' => 'required|min:10|max:30',
            'kec' => 'required|min:1|max:3',
            'kel' => 'required|min:1|max:3',
            'tps' => 'required|min:1|max:3',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:3',
            'dapil' => 'required|min:1|max:2',
            'password' => 'required|min:6',
            'confirmation' => 'required|same:password|min:6',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],[
            'fname.required'=>'Nama depan tidak boleh kosong!',
            'fname.min'=>'Maaf Nama depan minimal 4 karakter!',
            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
            'lname.required'=>'Nama belakang tidak boleh kosong!',
            'lname.max'=>'Nama maximal 15 karakter!',
            'lname.min'=>' Nama belakang minimal 4 karakter!',
            'nik.required' => 'NIK tidak boleh kosong!',
            'nik.min' => 'NIK minimal 16 karakter!',
            'nik.max' => 'NIK maximal 16 karakter!',
            'nik.unique' => 'NIK sudah terdaftar.',
            'telp.required' => 'Telephone boleh kosong!',
            'telp.min' => 'Telephone minimal 11 karakter!',
            'telp.max' => 'Telephone maximal 13 karakter!',
            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
            'alamat.required' => 'Alamat tidak boleh kosong!',
            'alamat.min' => 'Alamat minimal 10 karakter!',
            'alamat.max' => 'Alamat minimal 30 karakter!',
            'kec.required' => 'Kecapatan tidak boleh kosong!',
            'kel.required' => 'Kelurahan tidak boleh kosong!',
            'tps.required' => 'TPS tidak boleh kosong!',
            'prov.required' => 'Provinsi tidak boleh kosong',
            'kab.required' => 'Kabupaten tidak boleh kosong',
            'dapil.required' => 'Dapil tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal 6 karakter!',
            'confirmation.required' => 'Konfirmasi password tidak boleh kosong!',
            'confirmation.min' => 'Maaf, password minimal 6 karakter!',
            'confirmation.same' => 'Maaf, password yang Anda masukkan tidak sama!'
        ]);

        $image = $request->file('foto');
        $foto = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('img/saksi'), $foto);

        $data = ['fname' => $request->fname,
                'lname' => $request->lname,
                'nik' => $request->nik,
                'telp' => $request->telp,
                'gender' => $request->gender,
                'alamat' => $request->alamat,
                'kec' => $request->kec,
                'kel' => $request->kel,
                'tps' => $request->tps,
                'prov' => $request->prov,
                'kab' => $request->kab,
                'dapil' => $request->dapil,
                'password' => bcrypt($request->password),
            	'foto' => $foto];

        $req = new saksiModel();
        $req = $req->registerPost($data);
        $req = json_decode(json_encode($req), true);
        if($req[0]['msg'] == "success")
        {
            return redirect()->back()->with('alert-success','Registrasi data saksi sukses!');
        }
        else
        {
            return redirect()->back()->with('alert','Registrasi data saksi gagal!');
        }
    }

    function updateSaksiProfile(Request $request)
    {
    	if($request->hasFile('fotos'))
    	{
    		$this->validate($request, [
    		'id' => 'required|min:1|max:2',
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'nik' => 'required|min:16|unique:saksi,nik,'.$request->id.'|max:16',
            'telp' => 'required|min:11|max:13',
            'gender' => 'required|min:1|max:1',
            'alamat' => 'required|min:10|max:30',
            'kec' => 'required|min:1|max:3',
            'kel' => 'required|min:1|max:3',
            'tps' => 'required|min:1|max:5',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:3',
            'dapil' => 'required|min:1|max:2',
            'fotos' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
	        ],[
	        	'id.required' => 'ID saksi harus diisi!',
            	'id.max' => 'ID saksi maximal 2 karakter!',
            	'id.min' => 'ID saksi minimal 1 karakter!',
	            'fname.required'=>'Nama depan tidak boleh kosong!',
	            'fname.min'=>'Maaf Nama depan minimal 4 karakter!',
	            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
	            'lname.required'=>'Nama belakang tidak boleh kosong!',
	            'lname.max'=>'Nama maximal 15 karakter!',
	            'lname.min'=>' Nama belakang minimal 4 karakter!',
	            'nik.required' => 'NIK tidak boleh kosong!',
	            'nik.min' => 'NIK minimal 16 karakter!',
	            'nik.max' => 'NIK maximal 16 karakter!',
	            'nik.unique' => 'NIK sudah terdaftar.',
	            'telp.required' => 'Telephone boleh kosong!',
	            'telp.min' => 'Telephone minimal 11 karakter!',
	            'telp.max' => 'Telephone maximal 13 karakter!',
	            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
	            'alamat.required' => 'Alamat tidak boleh kosong!',
	            'alamat.min' => 'Alamat minimal 10 karakter!',
	            'alamat.max' => 'Alamat minimal 30 karakter!',
	            'kec.required' => 'Kecapatan tidak boleh kosong!',
	            'kel.required' => 'Kelurahan tidak boleh kosong!',
	            'tps.required' => 'TPS tidak boleh kosong!',
	            'prov.required' => 'Provinsi tidak boleh kosong',
	            'kab.required' => 'Kabupaten tidak boleh kosong',
	            'dapil.required' => 'Dapil tidak boleh kosong',
	        ]);

	        $image = $request->file('fotos');
	        $foto = time().'.'.$image->getClientOriginalExtension();
	        $image->move(public_path('img/saksi'), $foto);

	        $data = ['id' => $request->id,
	        		'fname' => $request->fname,
	                'lname' => $request->lname,
	                'nik' => $request->nik,
	                'telp' => $request->telp,
	                'gender' => $request->gender,
	                'alamat' => $request->alamat,
	                'kec' => $request->kec,
	                'kel' => $request->kel,
	                'tps' => $request->tps,
	                'prov' => $request->prov,
	                'kab' => $request->kab,
	                'dapil' => $request->dapil,
	                'password' => bcrypt($request->password),
	            	'foto' => $foto];
    	}
    	else
    	{
    		$this->validate($request, [
    		'id' => 'required|min:1|max:2',
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'nik' => 'required|min:16|unique:saksi,nik,'.$request->id.'|max:16',
            'telp' => 'required|min:11|max:13',
            'gender' => 'required|min:1|max:1',
            'alamat' => 'required|min:10|max:30',
            'kec' => 'required|min:1|max:3',
            'kel' => 'required|min:1|max:3',
            'tps' => 'required|min:1|max:5',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:3',
            'dapil' => 'required|min:1|max:2',
            'foto' => 'required'
	        ],[
	        	'id.required' => 'ID saksi harus diisi!',
	            'id.max' => 'ID saksi maximal 2 karakter!',
	            'id.min' => 'ID saksi minimal 1 karakter!',
	            'fname.required'=>'Nama depan tidak boleh kosong!',
	            'fname.min'=>'Maaf Nama depan minimal 4 karakter!',
	            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
	            'lname.required'=>'Nama belakang tidak boleh kosong!',
	            'lname.max'=>'Nama maximal 15 karakter!',
	            'lname.min'=>' Nama belakang minimal 4 karakter!',
	            'nik.required' => 'NIK tidak boleh kosong!',
	            'nik.min' => 'NIK minimal 16 karakter!',
	            'nik.max' => 'NIK maximal 16 karakter!',
	            'nik.unique' => 'NIK sudah terdaftar.',
	            'telp.required' => 'Telephone boleh kosong!',
	            'telp.min' => 'Telephone minimal 11 karakter!',
	            'telp.max' => 'Telephone maximal 13 karakter!',
	            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
	            'alamat.required' => 'Alamat tidak boleh kosong!',
	            'alamat.min' => 'Alamat minimal 10 karakter!',
	            'alamat.max' => 'Alamat minimal 30 karakter!',
	            'kec.required' => 'Kecapatan tidak boleh kosong!',
	            'kel.required' => 'Kelurahan tidak boleh kosong!',
	            'tps.required' => 'TPS tidak boleh kosong!',
	            'prov.required' => 'Provinsi tidak boleh kosong',
	            'kab.required' => 'Kabupaten tidak boleh kosong',
	            'dapil.required' => 'Dapil tidak boleh kosong',
	        ]);

	        $data = ['id' => $request->id,
        		'fname' => $request->fname,
    			'lname' => $request->lname,
    			'nik' => $request->nik,
    			'telp' => $request->telp,
    			'gender' => $request->gender,
    			'alamat' => $request->alamat,
    			'kec' => $request->kec,
    			'kel' => $request->kel,
    			'tps' => $request->tps,
    			'prov' => $request->prov,
    			'kab' => $request->kab,
    			'dapil' => $request->dapil,
    			'foto' => $request->foto
    			];
    	}

    	$req = new saksiModel();
    	$req = $req->updateProfile($data);
    	$req = json_decode(json_encode($req), true);
    	if($req[0]['msg'] == "success")
    	{
    		return redirect()->back()->with('alert-success','Update data saksi sukses!');
    	}
    	else
    	{
    		return redirect()->back()->with('alert','Update data saksi gagal!');
    	}
    }

    function getAllSaksi()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$req = new saksiModel();
    		$req = $req->getAllSaksi();

    		return view('admin.saksi.userlist', compact('req'));
	    }
    }

    function editSaksi($nik, $id_saksi)
    {
	    if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new saksiModel();
	    	$data = $data->getProfile($nik, $id_saksi);
	    	$kecamatan = new dataModel();
	    	$kecs = $kecamatan->getKec(1);
	    	$kels = $kecamatan->getKel($data->id_kec);
	    	$tps = $kecamatan->getTps($data->id_kel);
	    	return view('admin.saksi.edit', compact('data', 'kecs', 'kels', 'tps'));
	    }
    }

    function viewSaksi($nik, $id_saksi)
    {
	    if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new saksiModel();
	    	$data = $data->getProfile($nik, $id_saksi);
	    	$kecamatan = new dataModel();
	    	return view('admin.saksi.view', compact('data'));
	    }
    }

    function deleteSaksi($nik, $id_saksi)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new saksiModel();
	    	$req = $data->deleteSaksi($nik, $id_saksi);
        	$req = json_decode(json_encode($req), true);
        	if($req[0]['msg'] == "success")
	    	{
	    		return "Hapus data saksi sukses!";
	    	}
	    	elseif($req[0]['msg'] == "data not found")
	    	{
	    		return "Data saksi dengan NIK dan ID tersebut tidak ditemukan!";
	    	}
	    	else
	    	{
	    		return "Hapus data saksi gagal!";
	    	}
    	}
	}

	function registerCaleg()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new dataModel();
	    	$kec = $data->getKec(1);
	    	$partai = $data->getPartai();
	    	return view('admin.caleg.register', compact('kec', 'partai'));
	    }
    }

    function registerPostCaleg(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'gender' => 'required|min:1|max:1',
            'partai' => 'required|min:1|max:2',
            'tingkat' => 'required|min:1|max:1',
            'kec' => 'required|min:1|max:3',
            'kel' => 'required|min:1|max:3',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:3',
            'dapil' => 'required|min:1|max:2',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],[
            'fname.required'=>'Nama depan tidak boleh kosong!',
            'fname.min'=>'Maaf Nama depan minimal 4 karakter!',
            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
            'lname.required'=>'Nama belakang tidak boleh kosong!',
            'lname.max'=>'Nama maximal 15 karakter!',
            'lname.min'=>' Nama belakang minimal 4 karakter!',
            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
            'partai.required' => 'Partai harus diisi!',
            'partai.max' => 'Partai maximal 1 karakter!',
            'partai.max' => 'Partai minimal 1 karakter!',
            'tingkat.required' => 'Tingkat harus diisi!',
            'tingkat.max' => 'Tingkat maximal 1 karakter!',
            'tingkat.max' => 'Tingkat minimal 1 karakter!',
            'kec.required' => 'Kecapatan tidak boleh kosong!',
            'kel.required' => 'Kelurahan tidak boleh kosong!',
            'prov.required' => 'Provinsi tidak boleh kosong',
            'kab.required' => 'Kabupaten tidak boleh kosong',
            'dapil.required' => 'Dapil tidak boleh kosong',
        ]);
        $image = $request->file('foto');
        $foto = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('img/caleg'), $foto);

        $data = ['fname' => $request->fname,
                'lname' => $request->lname,
                'gender' => $request->gender,
                'partai' => $request->partai,
                'kec' => $request->kec,
                'kel' => $request->kel,
                'prov' => $request->prov,
                'kab' => $request->kab,
                'dapil' => $request->dapil,
            	'tingkat' => $request->tingkat,
            	'foto' => $foto
            	];

        $req = new calegModel();
        $req = $req->registerPost($data);
        $req = json_decode(json_encode($req), true);
        if($req[0]['msg'] == "success")
        {
            return redirect()->back()->with('alert-success','Registrasi data caleg sukses!');
        }
        else
        {
            return redirect()->back()->with('alert','Registrasi data caleg gagal!');
        }
    }

    function getAllCaleg()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new calegModel();
    		$req = $req->getAllCaleg();

    		return view('admin.caleg.userlist', compact('req'));
	    }
    }

    function viewCaleg($id_caleg)
    {
	    if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new calegModel();
	    	$data = $data->getProfile($id_caleg);
	    	$kecamatan = new dataModel();
	    	return view('admin.caleg.view', compact('data'));
	    }
    }

    function deleteCaleg($id_caleg)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new calegModel();
	    	$req = $data->deleteCaleg($id_caleg);
        	$req = json_decode(json_encode($req), true);
        	if($req[0]['msg'] == "success")
	    	{
	    		return "Hapus data saksi sukses!";
	    	}
	    	elseif($req[0]['msg'] == "data not found")
	    	{
	    		return "Data caleg ID tersebut tidak ditemukan!";
	    	}
	    	else
	    	{
	    		return "Hapus data saksi gagal!";
	    	}
    	}
	}

	function editCaleg($id_caleg)
    {
	    if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new calegModel();
	    	$data = $data->getProfile($id_caleg);
	    	$kecamatan = new dataModel();
	    	$kecs = $kecamatan->getKec(1);
	    	$kels = $kecamatan->getKel($data->id_kec);
	    	$partais = $kecamatan->getPartai();
	    	return view('admin.caleg.edit', compact('data', 'kecs', 'kels', 'partais'));
	    }
    }

    function updateCalegProfile(Request $request)
    {
    	$data = [];
    	if($request->hasFile('fotos'))
    	{
    		$this->validate($request, [
    		'id' => 'required|min:1|max:2',
    		'id.required' => 'ID caleg harus diisi!',
	        'id.max' => 'ID caleg maximal 2 karakter!',
	        'id.min' => 'ID caleg minimal 1 karakter!',
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'gender' => 'required|min:1|max:1',
            'partai' => 'required|min:1|max:2',
            'tingkat' => 'required|min:1|max:1',
            'kec' => 'required|min:1|max:3',
            'kel' => 'required|min:1|max:3',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:3',
            'dapil' => 'required|min:1|max:2',
            'fotos' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
	        ],[
	            'fname.required'=>'Nama depan tidak boleh kosong!',
	            'fname.min'=>'Maaf Nama depan minimal 4 karakter!',
	            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
	            'lname.required'=>'Nama belakang tidak boleh kosong!',
	            'lname.max'=>'Nama maximal 15 karakter!',
	            'lname.min'=>' Nama belakang minimal 4 karakter!',
	            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
	            'partai.required' => 'Partai harus diisi!',
	            'partai.max' => 'Partai maximal 1 karakter!',
	            'partai.max' => 'Partai minimal 1 karakter!',
	            'tingkat.required' => 'Tingkat harus diisi!',
	            'tingkat.max' => 'Tingkat maximal 1 karakter!',
	            'tingkat.max' => 'Tingkat minimal 1 karakter!',
	            'kec.required' => 'Kecapatan tidak boleh kosong!',
	            'kel.required' => 'Kelurahan tidak boleh kosong!',
	            'prov.required' => 'Provinsi tidak boleh kosong',
	            'kab.required' => 'Kabupaten tidak boleh kosong',
	            'dapil.required' => 'Dapil tidak boleh kosong',
	        ]);
	        $image = $request->file('fotos');
	        $foto = time().'.'.$image->getClientOriginalExtension();
	        $image->move(public_path('img/caleg'), $foto);

	        $data = ['id' => $request->id,
	        		'fname' => $request->fname,
	                'lname' => $request->lname,
	                'gender' => $request->gender,
	                'partai' => $request->partai,
	                'kec' => $request->kec,
	                'kel' => $request->kel,
	                'prov' => $request->prov,
	                'kab' => $request->kab,
	                'dapil' => $request->dapil,
	            	'tingkat' => $request->tingkat,
	            	'foto' => $foto
	            	];
    	}
    	else
    	{
    		$this->validate($request, [
        	'id' => 'required|min:1|max:2',
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'gender' => 'required|min:1|max:1',
            'partai' => 'required|min:1|max:1',
            'tingkat' => 'required|min:1|max:1',
            'kec' => 'required|min:1|max:3',
            'kel' => 'required|min:1|max:3',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:2',
            'dapil' => 'required|min:1|max:2',
            'foto' => 'required'
	        ],[
	        	'id.required' => 'ID caleg harus diisi!',
	            'id.max' => 'ID caleg maximal 2 karakter!',
	            'id.min' => 'ID caleg minimal 1 karakter!',
	            'fname.required'=>'Nama depan tidak boleh kosong!',
	            'fname.min'=>'Maaf Nama depan minimal 4 karakter!',
	            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
	            'lname.required'=>'Nama belakang tidak boleh kosong!',
	            'lname.max'=>'Nama maximal 15 karakter!',
	            'lname.min'=>' Nama belakang minimal 4 karakter!',
	            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
	            'partai.required' => 'Partai harus diisi!',
	            'partai.max' => 'Partai maximal 1 karakter!',
	            'partai.min' => 'Partai minimal 1 karakter!',
	            'tingkat.required' => 'Tingkat harus diisi!',
	            'tingkat.max' => 'Tingkat maximal 1 karakter!',
	            'tingkat.min' => 'Tingkat minimal 1 karakter!',
	            'kec.required' => 'Kecapatan tidak boleh kosong!',
	            'kel.required' => 'Kelurahan tidak boleh kosong!',
	            'prov.required' => 'Provinsi tidak boleh kosong',
	            'kab.required' => 'Kabupaten tidak boleh kosong',
	            'dapil.required' => 'Dapil tidak boleh kosong',
	        ]);

	        $data = ['id' => $request->id,
	        		'fname' => $request->fname,
	                'lname' => $request->lname,
	                'gender' => $request->gender,
	                'partai' => $request->partai,
	                'kec' => $request->kec,
	                'kel' => $request->kel,
	                'prov' => $request->prov,
	                'kab' => $request->kab,
	                'dapil' => $request->dapil,
	            	'tingkat' => $request->tingkat,
	            	'foto' => $request->foto];
    	}

        $req = new calegModel();
        $req = $req->updateProfile($data);
        $req = json_decode(json_encode($req), true);
        if($req[0]['msg'] == "success")
        {
            return redirect()->back()->with('alert-success', 'Update data caleg sukses!');
    	}
    	else
    	{
    		return redirect()->back()->with('alert','Update data caleg gagal!');
    	}
    }

    function registerTps()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new dataModel();
	    	$kec = $data->getKec(1);
	    	
	    	return view('admin.tps.register', compact('kec'));
	    }
    }

    function registerPostTps(Request $request)
    {
        $this->validate($request, [
            'tps' => 'required|min:4|max:10',
            'kec' => 'required|min:1|max:3',
            'kel' => 'required|min:1|max:3',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:3',
            'dapil' => 'required|min:1|max:2',
        ],[
            'tps.required'=>'Nama depan tidak boleh kosong!',
            'tps.min'=>'Maaf Nama depan minimal 4 karakter!',
            'tps.max'=>'Maaf Nama depan maximal 15 karakter!',
            'kec.required' => 'Kecapatan tidak boleh kosong!',
            'kel.required' => 'Kelurahan tidak boleh kosong!',
            'prov.required' => 'Provinsi tidak boleh kosong',
            'kab.required' => 'Kabupaten tidak boleh kosong',
            'dapil.required' => 'Dapil tidak boleh kosong',
        ]);
        $data = ['tps' => $request->tps,
                'kec' => $request->kec,
                'kel' => $request->kel,
                'prov' => $request->prov,
                'kab' => $request->kab,
                'dapil' => $request->dapil
            	];

        $req = new tpsModel();
        $req = $req->registerPost($data);
        $req = json_decode(json_encode($req), true);
        if($req[0]['msg'] == "success")
        {
            return redirect()->back()->with('alert-success','Input TPS sukses!');
        }
        else
        {
            return redirect()->back()->with('alert','Input TPS gagal!');
        }
    }

    function getAllTps()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new tpsModel();
    		$req = $req->getAllTps();

    		return view('admin.tps.userlist', compact('req'));
	    }
    }

    function editTps($id_tps)
    {
	    if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new tpsModel();
	    	$data = $data->getProfile($id_tps);
	    	$kecamatan = new dataModel();
	    	$kecs = $kecamatan->getKec(1);
	    	$kels = $kecamatan->getKel($data->id_kec);
	    	return view('admin.tps.edit', compact('data', 'kecs', 'kels'));
	    }
    }

    function updateTps(Request $request)
    {
        $this->validate($request, [
        	'id' => 'required|min:1|max:4',
            'tps' => 'required|min:4|max:10',
            'kec' => 'required|min:1|max:3',
            'kel' => 'required|min:1|max:3',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:3',
            'dapil' => 'required|min:1|max:2',
        ],[
            'tps.required'=>'Nama depan tidak boleh kosong!',
            'tps.min'=>'Maaf Nama depan minimal 4 karakter!',
            'tps.max'=>'Maaf Nama depan maximal 15 karakter!',
            'kec.required' => 'Kecapatan tidak boleh kosong!',
            'kel.required' => 'Kelurahan tidak boleh kosong!',
            'prov.required' => 'Provinsi tidak boleh kosong',
            'kab.required' => 'Kabupaten tidak boleh kosong',
            'dapil.required' => 'Dapil tidak boleh kosong',
        ]);
        $data = ['id' => $request->id,
        		'tps' => $request->tps,
                'kec' => $request->kec,
                'kel' => $request->kel,
                'prov' => $request->prov,
                'kab' => $request->kab,
                'dapil' => $request->dapil
            	];

        $req = new tpsModel();
        $req = $req->updateProfile($data);
        $req = json_decode(json_encode($req), true);
        if($req[0]['msg'] == "success")
        {
            return redirect()->back()->with('alert-success','Update data TPS sukses!');
        }
        else
        {
            return redirect()->back()->with('alert','Update data TPS gagal!');
        }
    }

    function viewTps($id_tps)
    {
	    if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new tpsModel();
	    	$data = $data->getProfile($id_tps);
	    	$kecamatan = new dataModel();
	    	$kecs = $kecamatan->getKec(1);
	    	$kels = $kecamatan->getKel($data->id_kec);
	    	return view('admin.tps.view', compact('data', 'kecs', 'kels'));
	    }
    }

    function deleteTps($id_tps)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new tpsModel();
	    	$req = $data->deleteTps($id_tps);
	    	#$req->delete();
        	return $req;
    	}
	}

	function registerPartai()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	return view('admin.partai.register');
	    }
    }

	function registerPostPartai(Request $request)
    {
        $this->validate($request, [
            'partai' => 'required|min:5|max:25',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],[ 'partai.required' => 'Partai harus diisi!',
            'partai.max' => 'Partai maximal 25 karakter!',
            'partai.min' => 'Partai minimal 5 karakter!',
        ]);
        $image = $request->file('foto');
        $foto = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('img/partai'), $foto);

        $data = ['partai' => $request->partai,
            	'foto' => $foto
            	];

        $req = new partaiModel();
        $req = $req->registerPost($data);
        if($req)
        {
            return redirect()->back()->with('alert-success','Registrasi data partai sukses!');
        }
        else
        {
            return redirect()->back()->with('alert','Registrasi data partai gagal!');
        }
    }

    function getAllPartai()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new partaiModel();
    		$req = $req->getAllPartai();

    		return view('admin.partai.userlist', compact('req'));
	    }
    }

    function editPartai($id_partai)
    {
	    if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new partaiModel();
	    	$data = $data->getProfile($id_partai);
	    	return view('admin.partai.edit', compact('data'));
	    }
    }

    function updatePartai(Request $request)
    {
    	$data = [];
    	if($request->hasFile('fotos'))
    	{
    		$this->validate($request, [
            'partai' => 'required|min:5|max:25',
            'fotos' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
	        ],[ 'partai.required' => 'Partai harus diisi!',
	            'partai.max' => 'Partai maximal 25 karakter!',
	            'partai.min' => 'Partai minimal 5 karakter!',
	        ]);
	        $image = $request->file('fotos');
       	 	$foto = time().'.'.$image->getClientOriginalExtension();
        	$image->move(public_path('img/partai'), $foto);
	        $data = ['id' => $request->id,
	        		'partai' => $request->partai,
	            	'foto' => $foto
	            	];
    	}
    	else
    	{
    		$this->validate($request, [
            'partai' => 'required|min:5|max:25',
            'foto' => 'required'
	        ],[ 'partai.required' => 'Partai harus diisi!',
	            'partai.max' => 'Partai maximal 25 karakter!',
	            'partai.min' => 'Partai minimal 5 karakter!',
	        ]);
	        $data = ['id' => $request->id,
	        		'partai' => $request->partai,
	            	'foto' => $request->foto
	            	];
    	}
        

        $req = new partaiModel();
        $req = $req->updateProfile($data);
        if($req)
        {
            return redirect()->back()->with('alert-success','Update data Partai sukses!');
        }
        else
        {
            return redirect()->back()->with('alert', 'Update data Partai gagal!');
        }
    }

    function viewPartai($id_partai)
    {
	    if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new partaiModel();
	    	$data = $data->getProfile($id_partai);
	    	return view('admin.partai.view', compact('data'));
	    }
    }

    function deletePartai($id_partai)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new partaiModel();
	    	$req = $data->deletePartai($id_partai);
	    	#$req->delete();
        	return $req;
    	}
	}
}
