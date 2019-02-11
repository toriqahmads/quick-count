<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\dataModel;
class dataController extends Controller
{
    function getProv()
    {
        $data = new dataModel();
        $data = $data->getProv();

        return $data;
    }

    function getProvById($id)
    {
        $data = new dataModel();
        $data = $data->getProvById($id);

        return $data;
    }

    function getAllKab()
    {
        $data = new dataModel();
        $data = $data->getALlKab();

        return $data;
    }

	function getKab($id_prov)
	{
		$data = new dataModel();
	    $data = $data->getKab($id_prov);

	    return $data;
	}

    function getKabById($id)
    {
        $data = new dataModel();
        $data = $data->getKabById($id);

        return $data;
    }

	function getKec($id_kab)
	{
		$data = new dataModel();
	    $data = $data->getKec($id_kab);

	    return $data;
	}

    function getKecById($id)
    {
        $data = new dataModel();
        $data = $data->getKecById($id);

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

    function getAllDapil()
    {
    	$data = new dataModel();
    	$data = $data->getAllDapil();

    	return $data;
    }

    function getDapilByProv($prov, $jenis)
    {
        $data = new dataModel();
        $data = $data->getDapilByProv($prov, $jenis);

        return $data;
    }

    function getDapilByKab($prov, $kab, $jenis)
    {
        $data = new dataModel();
        $data = $data->getDapilByKab($prov, $kab, $jenis);

        return $data;
    }

    function getPartai()
    {
    	$data = new dataModel();
    	$data = $data->getPartai();

    	return $data;
    }

    function getCaleg($id_dapil, $id_partai, $tingkat)
    {
        $data = new dataModel();
        $data = $data->getAllCaleg($id_dapil, $id_partai, $tingkat);

        return $data;
    }

    function getCalegDpd($prov, $id_partai, $tingkat)
    {
        $data = new dataModel();
        $data = $data->getAllCalegDpd($prov, $id_partai, $tingkat);

        return $data;
    }

    function getAllPres($id_partai, $tingkat)
    {
        $data = new dataModel();
        $data = $data->getAllPres($id_partai, $tingkat);

        return $data;
    }
}
