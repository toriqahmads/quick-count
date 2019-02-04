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

class tabulasiController extends Controller
{
    	function tabulasiDapil()
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
	    	$data = new dataModel();
	    	$dapil = $data->getDapil();
	    	$partai = $data->getPartai();
	    	$kec = $data->getKec(1);

	    	return view('admin.tabulasi.view', compact('dapil', 'partai', 'kec'));
	    }
    }

    function tabulasiTps()
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
	    	$data = new dataModel();
	    	$dapil = $data->getDapil();
	    	$partai = $data->getPartai();
	    	$kec = $data->getKec(1);

	    	return view('admin.tabulasi.view2', compact('dapil', 'partai', 'kec'));
	    }
    }
}
