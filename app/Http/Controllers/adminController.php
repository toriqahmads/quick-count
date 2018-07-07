<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\adminModel;
use App\dataModel;
class adminController extends Controller
{
    function index()
    {
	    if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    else
	    {
	    	$data = new adminModel();
	    	$data = $data->getProfile(Session::get('username'), Session::get('id_saksi'));
	    	$kecamatan = new dataModel();
	    	$kecs = $kecamatan->getKec(1);
	    	$kels = $kecamatan->getKel($data->id_kel);
	    	$tps = $kecamatan->getTps($data->id_tps);
	    	return view('admin.home.index', compact('data', 'kecs', 'kels', 'tps'));
	    }
    }

    function login()
    {
    	if(Session::get('login'))
	    {
	    	$data = new adminModel();
	    	$data = $data->getProfile(Session::get('username'), Session::get('id_saksi'));
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
	    	
	    	if(count($data) > 0)
	    	{
	    		if(Hash::check($password, $data->pass))
	    		{
	    			Session::put('username', $data->username);
	    			Session::put('id', $data->id);
	    			Session::put('id_saksi', $data->id_saksi);
	    			Session::put('login', true);

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

    function registerPost(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'nik' => 'required|min:16|unique:saksi|max:16',
            'telp' => 'required|min:11|max:13',
            'gender' => 'required|min:1|max:1',
            'alamat' => 'required|min:10|max:30',
            'kec' => 'required|min:1|max:1',
            'kel' => 'required|min:1|max:1',
            'tps' => 'required|min:1|max:1',
            'prov' => 'required|min:1|max:1',
            'kab' => 'required|min:1|max:1',
            'dapil' => 'required|min:1|max:1',
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
            return redirect('admin/login')->with('alert-success','Registrasi saksi sukses!');
        }
        else
        {
            return redirect('admin/register')->with('alert','Registrasi saksi gagal!');
        }
    }

    function updateProfile(Request $request)
    {
    	$this->validate($request, [
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'nik' => 'required|min:16|unique:saksi,nik,'.$request->id.'|max:16',
            'telp' => 'required|min:11|max:13',
            'gender' => 'required|min:1|max:1',
            'alamat' => 'required|min:10|max:30',
            'kec' => 'required|min:1|max:1',
            'kel' => 'required|min:1|max:1',
            'tps' => 'required|min:1|max:1',
            'prov' => 'required|min:1|max:1',
            'kab' => 'required|min:1|max:1',
            'dapil' => 'required|min:1|max:1',
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
    			'dapil' => $request->dapil];

    	$req = new adminModel();
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
	    else
	    {
	    	$req = new adminModel();
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
	    else
	    {
	    	$data = new adminModel();
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
	    else
	    {
	    	$data = new adminModel();
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
	    else
	    {
	    	$data = new adminModel();
	    	$req = $data->deleteSaksi($nik, $id_saksi);
        	$req = json_decode(json_encode($req), true);
        	if($req[0]['msg'] == "success")
	    	{
	    		return redirect()->back()->with('alert-success','Delete data saksi sukses!');
	    	}
	    	elseif($req[0]['msg'] == "data not found")
	    	{
	    		return redirect()->back()->with('alert','Data saksi dengan NIK dan ID tersebut tidak ditemukan!');
	    	}
	    	else
	    	{
	    		return redirect()->back()->with('alert','Delete data saksi gagal!');
	    	}
    	}
	}
}
