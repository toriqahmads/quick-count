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
use App\suaraModel;
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
}
