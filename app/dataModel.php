<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class dataModel extends Model
{
    function getProv()
    {
        $data = DB::table('prov')
                ->get();
        return $data;
    }

    function getProvById($id)
    {
        $data = DB::table('prov')
                ->where('id', $id)
                ->get();
        return $data;
    }

	function getKab($id_prov)
    {
    	$data = DB::table('kab')
                ->join('prov', 'prov.id', '=', 'kab.id_prov')
    			->where('id_prov', $id_prov)
                ->select('kab.*')
    			->get();
    	return $data;
    }

    function getAllKab()
    {
        $data = DB::table('kab')
                ->get();
        return $data;
    }

    function getKabById($id)
    {
        $data = DB::table('kab')
                ->where('kab.id', $id)
                ->get();
        return $data;
    }

    function getKec($id_kab)
    {
    	$data = DB::table('kec')
                ->join('kab', 'kab.id', '=', 'kec.id_kab')
                ->join('prov', 'prov.id', '=', 'kec.id_prov')
                ->join('dapil', 'dapil.id', '=', 'kec.id_dapil')
                ->select('kec.id as id_kec', 'kec.kec', 'kab.id as id_kab', 'kab.kab', 'prov.id as id_prov', 'prov.prov', 'dapil.id as id_dapil')
    			->where('kec.id_kab', $id_kab)
    			->get();
    	return $data;
    }

    function getKecById($id)
    {
        $data = DB::table('kec')
                ->where('kec.id', $id)
                ->select('kec.*')
                ->get();
        return $data;
    }

    function getKel($id_kec)
    {
    	$data = DB::table('kel')
                ->join('kec', 'kec.id', '=', 'kel.id_kec')
                ->join('kab', 'kab.id', '=', 'kel.id_kab')
                ->join('prov', 'prov.id', '=', 'kel.id_prov')
                ->select('kel.id as id_kel', 'kel.kel', 'kab.id as id_kab', 'kab.kab', 'kec.id as id_kec', 'kec.kec', 'kec.id_dapil', 'prov.id as id_prov', 'prov.prov')
    			->where('id_kec', $id_kec)
    			->get();
    	return $data;
    }

    function getTps($id_kel)
    {
        $data = DB::table('tps')
                ->where('id_kel', $id_kel)
                ->join('kel', 'kel.id', '=', 'tps.id_kel')
                ->join('kec', 'kec.id', '=', 'tps.id_kec')
                ->join('kab', 'kab.id', '=', 'tps.id_kab')
                ->join('prov', 'prov.id', '=', 'tps.id_prov')
                ->select('tps.id as id_tps', 'tps.tps', 'kel.id as id_kel', 'kel.kel', 'kab.id as id_kab', 'kab.kab', 'kec.id as id_kec', 'kec.kec', 'prov.id as id_prov', 'prov.prov')
                ->where('id_kel', $id_kel)
                ->get();
        return $data;
    }

    function getAllDapil()
    {
        $data = DB::table('dapil')
                ->get();
        return $data;
    }

    function getDapilByProv($prov, $jenis)
    {
        $data = DB::table('dapil')
                ->select('dapil.*')
                ->where('dapil.id_prov', $prov)
                ->where('dapil.jenis', $jenis)
                ->get();
        return $data;
    }

    function getDapilByKab($prov, $kab, $jenis)
    {
        $data = DB::table('dapil')
                ->select('dapil.*')
                ->where('dapil.id_prov', $prov)
                ->where('dapil.id_kab', $kab)
                ->where('dapil.jenis', $jenis)
                ->get();
        return $data;
    }

    function getPartai()
    {
        $data = DB::table('partai')
                ->orderBy('no_urut', 'asc')
                ->get();
        return $data;
    }

    function getAllCaleg($dapil, $partai, $tingkat)
    {
        $data = DB::table('pil')
                ->join('partai', 'partai.id', '=', 'pil.id_partai')
                ->join('dapil', 'dapil.id', '=', 'pil.id_dapil')
                ->where('pil.status', '=', 'l')
                ->where('dapil.id', '=', $dapil)
                ->where('partai.id', '=', $partai)
                ->where('pil.tingkat', '=', $tingkat)
                ->select('pil.*', 'partai.id as id_partai', 'partai.partai')
                ->orderBy('no_urut', 'asc')
                ->get();
        return $data;
    }

    function getAllCalegDpd($prov, $partai, $tingkat)
    {
        $data = DB::table('pil')
                ->join('partai', 'partai.id', '=', 'pil.id_partai')
                ->where('pil.status', '=', 'l')
                ->where('pil.id_prov', '=', $prov)
                ->where('partai.id', '=', $partai)
                ->where('pil.tingkat', '=', $tingkat)
                ->select('pil.*', 'partai.id as id_partai', 'partai.partai')
                ->orderBy('no_urut', 'asc')
                ->get();
        return $data;
    }

    function getAllPres($partai, $tingkat)
    {
        $data = DB::table('pil')
                ->join('partai', 'partai.id', '=', 'pil.id_partai')
                ->where('pil.status', '=', 'l')
                ->where('partai.id', '=', $partai)
                ->where('pil.tingkat', '=', $tingkat)
                ->select('pil.*', 'partai.id as id_partai', 'partai.partai')
                ->orderBy('no_urut', 'asc')
                ->get();
        return $data;
    }
}
