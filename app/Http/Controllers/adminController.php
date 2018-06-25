<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
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
            'fname' => 'required|min:4',
            'lname' => 'required|min:4',
            'nik' => 'required|min:16|unique:saksi',
            'telp' => 'required|min:11',
            'gender' => 'required|min:1',
            'alamat' => 'required|min:10',
            'kec' => 'required|min:1',
            'kel' => 'required|min:1',
            'tps' => 'required|min:1',
            'prov' => 'required|min:1',
            'kab' => 'required|min:1',
            'dapil' => 'required|min:1',
            'password' => 'required',
            'confirmation' => 'required|same:password',
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
    		'id' => 'required|min:1',
            'fname' => 'required|min:4',
            'lname' => 'required|min:4',
            'nik' => 'required|min:16',
            'telp' => 'required|min:11',
            'gender' => 'required|min:1',
            'alamat' => 'required|min:10',
            'kec' => 'required|min:1',
            'kel' => 'required|min:1',
            'tps' => 'required|min:1',
            'prov' => 'required|min:1',
            'kab' => 'required|min:1',
            'dapil' => 'required|min:1',
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
    		return redirect('admin')->with('alert-success','Update data saksi sukses!');
    	}
    	else
    	{
    		return redirect('admin')->with('alert','Update data saksi gagal!');
    	}
    }
}
