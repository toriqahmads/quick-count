<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\dataModel;
use App\calegModel;
use App\partaiModel;
use App\tabulasiDesaModel;

class tabulasiDesaController extends Controller
{
	function tabulasi()
    {
	    return view('admin.tabulasidesa.view');
    }

    function viewForm(Request $request)
    {
    	$jenis = $request->jenis;
    	$tingkat = $request->tingkat;

		return redirect()->route('view.tabulasi.desa', [$tingkat, $jenis]);
    }

    function viewTabulasi($tingkat, $jenis)
    {
    	$data = new dataModel();
    	$prov = $data->getProv();
    	$partai = $data->getPartai();
    	return view('admin.tabulasidesa.'.$tingkat.'.'.$jenis, compact('prov', 'partai'));
    }

    function tabulasiPartaiByKel($id_kel, $tingkat)
    {
    	$req = new tabulasiDesaModel();
		$req = $req->tabulasiPartaiByKel($id_kel, $tingkat);

		return $req;
    }

    function tabulasiCalegByKel($id_partai, $id_kel, $tingkat)
    {
    	$req = new tabulasiDesaModel();
    	$id_partai = json_decode($id_partai);
		$req = $req->tabulasiCalegByKel($id_partai, $id_kel, $tingkat);

		return $req;
    }

    function tabulasiPartaiByKec($id_kec, $tingkat)
    {
    	$req = new tabulasiDesaModel();
		$req = $req->tabulasiPartaiByKec($id_kec, $tingkat);

		return $req;
    }

    function tabulasiCalegByKec($id_partai, $id_kec, $tingkat)
    {
    	$req = new tabulasiDesaModel();
    	$id_partai = json_decode($id_partai);
		$req = $req->tabulasiCalegByKec($id_partai, $id_kec, $tingkat);

		return $req;
    }

    function tabulasiPartaiByKab($id_kab, $tingkat)
    {
    	$req = new tabulasiDesaModel();
		$req = $req->tabulasiPartaiByKab($id_kab, $tingkat);

		return $req;
    }

    function tabulasiCalegByKab($id_partai, $id_kab, $tingkat)
    {
    	$req = new tabulasiDesaModel();
    	$id_partai = json_decode($id_partai);
		$req = $req->tabulasiCalegByKab($id_partai, $id_kab, $tingkat);

		return $req;
    }

    function tabulasiPartaiByProv($id_prov, $tingkat)
    {
    	$req = new tabulasiDesaModel();
		$req = $req->tabulasiPartaiByProv($id_prov, $tingkat);

		return $req;
    }

    function tabulasiCalegByProv($id_partai, $id_prov, $tingkat)
    {
    	$req = new tabulasiDesaModel();
    	$id_partai = json_decode($id_partai);
		$req = $req->tabulasiCalegByProv($id_partai, $id_prov, $tingkat);

		return $req;
    }

    function tabulasiPartaiByDapil($id_dapil, $tingkat)
    {
    	$req = new tabulasiDesaModel();
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

    function tabulasiCalegByDapil($id_partai, $id_dapil, $tingkat)
    {
    	$id_partai = json_decode($id_partai);
    	$req = new tabulasiDesaModel();
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
