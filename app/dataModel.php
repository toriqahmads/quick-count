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

	function getKab($id_prov)
    {
    	$data = DB::table('kab')
                ->join('prov', 'prov.id', '=', 'kab.id_prov')
    			->where('id_prov', $id_prov)
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
    			->where('id_kab', $id_kab)
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

    function getDapil()
    {
        $data = DB::table('dapil')
                ->get();
        return $data;
    }

    function getPartai()
    {
        $data = DB::table('partai')
                ->get();
        return $data;
    }
}
