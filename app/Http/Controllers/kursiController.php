<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\kursiModel;
use App\dataModel;
use App\Services\Kursi;

class kursiController extends Controller
{
	function view($tingkat)
	{
		$data = new dataModel();
    	$prov = $data->getProv();
		return view('admin.kursi.kursi', compact('tingkat', 'prov'));
	}

	function hitungKursi($id_dapil, $tingkat)
	{
		$kursi = new kursiModel();
		$kursi = $kursi->getKursi($id_dapil);
		$data = $this->getVote($id_dapil, $tingkat);
		$hitung = new Kursi($data, $kursi->kursi, array(1, 3, 5, 7, 9, 11));
		$hitung->divide();
		$hitung->calculateSeat();
		$hasil = $hitung->getResult();
		$partai = new dataModel();
		$partai = $partai->getPartai();

		return view('admin.kursi.hitung', compact('hasil', 'partai'));
	}

    function getVote($id_dapil, $tingkat)
    {
    	$kursi = new kursiModel();
    	$data = $kursi->getVote($id_dapil, $tingkat);
    	$vote = [];
    	foreach ($data as $value) 
    	{
    		$vote[$value->partai] = $value->total_suara;
    	}
    	return $vote;
    }

    function getDevided($id_dapil, $tingkat)
	{
		$kursi = new kursiModel();
		$kursi = $kursi->getKursi($id_dapil);
		$data = $this->getVote($id_dapil, $tingkat);
		$hitung = new Kursi($data, $kursi, array(1, 3, 5, 7));
		$divided = $hitung->divide();
		$return = [];
		foreach ($divided as $divisor => $value) 
		{
			foreach ($value as $partai => $suara) 
			{
				$return[$partai][$divisor] = $suara;
			}
		}

		return $return;
	}

	function getTable($id_dapil, $tingkat)
	{
		$data = $this->getDevided($id_dapil, $tingkat);
		$divisor = array(1, 3, 5, 7);
		return view('admin.kursi.table', compact('divisor', 'data'));
	}

	function getWinner(Request $request)
	{
		$input = $request->all();
		$hasil = [];
		$kursi = new kursiModel();
		foreach ($input['kursi'] as $id => $limit) 
		{
			$hasil[] = $kursi->getWinner($input['dapil'], $input['tingkat'], $id, $limit);
		}

		return view('admin.kursi.winner', compact('hasil'));
	}
}
