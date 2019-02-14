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
use App\tabulasiModel;

class tabulasiController extends Controller
{
	function tabulasi()
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
	    	return view('admin.tabulasi.view');
	    }
    }

    function viewForm(Request $request)
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
	    	$jenis = $request->jenis;
	    	$tingkat = $request->tingkat;

  			return redirect()->route('view.tabulasi', [$tingkat, $jenis]);
	    }
    }

    function viewTabulasi($tingkat, $jenis)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new dataModel();
	    	$prov = $data->getProv();
	    	$partai = $data->getPartai();
	    	return view('admin.tabulasi.'.$tingkat.'.'.$jenis, compact('prov', 'partai'));
	    }
    }

    function tabulasiPartaiByTps($id_tps, $tingkat)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new tabulasiModel();
    		$req = $req->tabulasiPartaiByTps($id_tps, $tingkat);

    		return $req;
	    }
    }

    function tabulasiCalegByTps($id_partai, $id_tps, $tingkat)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new tabulasiModel();
	    	$id_partai = json_decode($id_partai);
    		$req = $req->tabulasiCalegByTps($id_partai, $id_tps, $tingkat);

    		return $req;
	    }
    }

    function tabulasiPartaiByKel($id_kel, $tingkat)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new tabulasiModel();
    		$req = $req->tabulasiPartaiByKel($id_kel, $tingkat);

    		return $req;
	    }
    }

    function tabulasiCalegByKel($id_partai, $id_kel, $tingkat)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new tabulasiModel();
	    	$id_partai = json_decode($id_partai);
    		$req = $req->tabulasiCalegByKel($id_partai, $id_kel, $tingkat);

    		return $req;
	    }
    }

    function tabulasiPartaiByKec($id_kec, $tingkat)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new tabulasiModel();
    		$req = $req->tabulasiPartaiByKec($id_kec, $tingkat);

    		return $req;
	    }
    }

    function tabulasiCalegByKec($id_partai, $id_kec, $tingkat)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new tabulasiModel();
	    	$id_partai = json_decode($id_partai);
    		$req = $req->tabulasiCalegByKec($id_partai, $id_kec, $tingkat);

    		return $req;
	    }
    }

    function tabulasiPartaiByKab($id_kab, $tingkat)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new tabulasiModel();
    		$req = $req->tabulasiPartaiByKab($id_kab, $tingkat);

    		return $req;
	    }
    }

    function tabulasiCalegByKab($id_partai, $id_kab, $tingkat)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new tabulasiModel();
	    	$id_partai = json_decode($id_partai);
    		$req = $req->tabulasiCalegByKab($id_partai, $id_kab, $tingkat);

    		return $req;
	    }
    }

    function tabulasiPartaiByProv($id_prov, $tingkat)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new tabulasiModel();
    		$req = $req->tabulasiPartaiByProv($id_prov, $tingkat);

    		return $req;
	    }
    }

    function tabulasiCalegByProv($id_partai, $id_prov, $tingkat)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new tabulasiModel();
	    	$id_partai = json_decode($id_partai);
    		$req = $req->tabulasiCalegByProv($id_partai, $id_prov, $tingkat);

    		return $req;
	    }
    }

    function tabulasiPartaiByDapil($id_dapil, $tingkat)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new tabulasiModel();
	    	if($tingkat == 'e')
	    	{
	    		$req = $req->tabulasiPartaiByDapil($id_dapil, $tingkat);
	    	}
	    	elseif($tingkat == 'd' || $tingkat == 'c')
	    	{
	    		$req = $req->tabulasiPartaiByDapilKab($id_dapil, $tingkat);
	    	}

    		return $req;
	    }
    }

    function tabulasiCalegByDapil($id_partai, $id_dapil, $tingkat)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$id_partai = json_decode($id_partai);
	    	$req = new tabulasiModel();
	    	if($tingkat == 'e')
	    	{
	    		$req = $req->tabulasiCalegByDapil($id_partai, $id_dapil, $tingkat);
	    	}
	    	elseif($tingkat == 'd' || $tingkat == 'c')
	    	{
	    		$req = $req->tabulasiCalegByDapilKab($id_partai, $id_dapil, $tingkat);
	    	}
    		

    		return $req;
	    }
    }
}
