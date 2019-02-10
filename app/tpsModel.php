<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class tpsModel extends Model
{
    function registerPost($data = array())
    {
    	$name = $data['tps'];
    	$kec = $data['kec'];
    	$kel = $data['kel'];
    	$prov = $data['prov'];
    	$kab = $data['kab'];
    	$dapil = $data['dapil'];

    	$req = DB::select('CALL input_tps(?, ?, ?, ?, ?, ?)', array($name, $dapil, $kel, $kec, $kab, $prov));

    	return $req;
    }

    function getAllTps()
    {
        $data = DB::table('tps')
                ->join('kel', 'kel.id', '=', 'tps.id_kel')
                ->join('kec', 'kec.id', '=', 'kel.id_kec')
                ->join('kab', 'kab.id', '=', 'kec.id_kab')
                ->join('prov', 'prov.id', '=', 'kab.id_prov')
                ->join('dapil', 'dapil.id', '=', 'tps.id_dapil')
                ->select('tps.*', 'kel.id as id_kel', 'kel.kel', 'kec.id as id_kec', 'kec.kec', 'kab.id as id_kab', 'kab.kab', 'prov.id as id_prov', 'prov.prov', 'dapil.id as dapil')
                ->paginate('10');
        return $data;
    }

    function getProfile($id_tps)
    {
        $data = DB::table('tps')
                ->join('kel', 'kel.id', '=', 'tps.id_kel')
                ->join('kec', 'kec.id', '=', 'kel.id_kec')
                ->join('kab', 'kab.id', '=', 'kec.id_kab')
                ->join('prov', 'prov.id', '=', 'kab.id_prov')
                ->join('dapil', 'dapil.id', '=', 'tps.id_dapil')
                ->where('tps.id', '=', $id_tps)
                ->select('tps.*', 'kel.id as id_kel', 'kel.kel', 'kec.id as id_kec', 'kec.kec', 'kab.id as id_kab', 'kab.kab', 'prov.id as id_prov', 'prov.prov', 'dapil.id as dapil')
                ->first();
        return $data;
    }

    function updateProfile($data = array())
    {
    	$id = $data['id'];
    	$name = $data['tps'];
    	$kec = $data['kec'];
    	$kel = $data['kel'];
    	$prov = $data['prov'];
    	$kab = $data['kab'];
    	$dapil = $data['dapil'];

    	$req = DB::select('CALL update_tps(?, ?, ?, ?, ?, ?, ?)', array($id, $name, $dapil, $kel, $kec, $kab, $prov));

    	return $req;
    }

    function deleteTps($id_tps)
    {
    	$req = DB::table('tps')
    			->where('tps.id', '=', $id_tps)
    			->delete();

    	return $req;
    }
}
