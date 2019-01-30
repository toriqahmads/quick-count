<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\dataModel;
class dataController extends Controller
{
	function getKab($id_prov)
	{
		$data = new dataModel();
	    $data = $data->getKab($id_prov);

	    return $data;
	}

	function getKec($id_kab)
	{
		$data = new dataModel();
	    $data = $data->getKec($id_kab);

	    return $data;
	}

    function getKel($id_kec)
    {
    	$data = new dataModel();
	    $data = $data->getKel($id_kec);

	    return $data;
    }

    function getTps($id_kel)
    {
    	$data = new dataModel();
	    $data = $data->getTps($id_kel);

	    return $data;
    }

    function getDapil()
    {
    	$data = new dataModel();
    	$data = $data->getDapil();

    	return $data;
    }

    function getPartai()
    {
    	$data = new dataModel();
    	$data = $data->getPartai();

    	return $data;
    }

    function getCaleg($id_dapil, $id_partai)
    {
        $data = new dataModel();
        $data = $data->getAllCaleg($id_dapil, $id_partai);

        return $data;
    }
}
