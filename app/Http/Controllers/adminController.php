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
	    	return redirect('index')->with('Anda harus login terlebih dahulu');
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
    	if(Session::get('login'))
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

    function register()
    {
    	if(Session::get('login'))
	    {
	    	return view('admin.home.index');
	    }
	    else
	    {
	    	$data = new dataModel();
	    	$data = $data->getKec(1);
	    	return view('admin.register.register', compact('data'));
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
                'password' => bcrypt($request->password)];

        $req = new adminModel();
        $req = $req->registerPost($data);
        $req = json_decode(json_encode($req), true);
        if($req[0]['msg'] == "success")
        {
            return redirect()->back()->with('alert-success','Registrasi data saksi sukses!');
        }
        else
        {
            return redirect()->back()->with('alert-success','Registrasi data saksi sukses!');
        }
    }

    function updateSaksiProfile(Request $request)
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
            'tps' => 'required|min:1|max:3',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:3',
            'dapil' => 'required|min:1|max:2',
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
    			];

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
	    	return redirect('index')->with('Anda harus login terlebih dahulu');
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
	    	return redirect('index')->with('Anda harus login terlebih dahulu');
	    }
	    else
	    {
	    	$data = new saksiModel();
	    	$data = $data->getProfile($nik, $id_saksi);
	    	$kecamatan = new dataModel();
	    	$kecs = $kecamatan->getKec(1);
	    	$kels = $kecamatan->getKel($data->id_kel);
	    	$tps = $kecamatan->getTps($data->id_tps);
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
	    	return redirect('index')->with('Anda harus login terlebih dahulu');
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
	    	return redirect('index')->with('Anda harus login terlebih dahulu');
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
	    	return view('admin.home.index');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('index')->with('Anda harus login terlebih dahulu');
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

        $data = ['fname' => $request->fname,
                'lname' => $request->lname,
                'gender' => $request->gender,
                'partai' => $request->partai,
                'kec' => $request->kec,
                'kel' => $request->kel,
                'prov' => $request->prov,
                'kab' => $request->kab,
                'dapil' => $request->dapil,
            	'tingkat' => $request->tingkat];

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
	    	return redirect('index')->with('Anda harus login terlebih dahulu');
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
	    	return redirect('index')->with('Anda harus login terlebih dahulu');
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
	    	return redirect('index')->with('Anda harus login terlebih dahulu');
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
	    	return redirect('index')->with('Anda harus login terlebih dahulu');
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

        $req = new calegModel();
        $req = $req->updateProfile($data);
        $req = json_decode(json_encode($req), true);
        if($req[0]['msg'] == "success")
        {
            return redirect()->back()->with('alert-success','Update data caleg sukses!');
    	}
    	else
    	{
    		return redirect()->back()->with('alert','Update data caleg gagal!');
    	}
    }
}
