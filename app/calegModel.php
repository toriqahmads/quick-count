<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class calegModel extends Model
{
    function registerPost($data = array())
    {
    	$fname = $data['fname'];
    	$lname = $data['lname'];
    	$partai = $data['partai'];
    	$gender = $data['gender'];
    	$kec = $data['kec'];
    	$kel = $data['kel'];
    	$prov = $data['prov'];
    	$kab = $data['kab'];
    	$dapil = $data['dapil'];
    	$tingkat = $data['tingkat'];

    	$req = DB::select('CALL input_data_pil(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($fname, $lname, $partai, $dapil, $prov, $kab, $kel, $tingkat, $gender));

    	return $req;
    }

    function getProfile($id_caleg)
    {
        $data = DB::table('pil')
                ->join('partai', 'partai.id', '=', 'pil.id_partai')
                ->join('kel', 'kel.id', '=', 'pil.id_kel')
                ->join('kec', 'kec.id', '=', 'kel.id_kec')
                ->join('kab', 'kab.id', '=', 'kec.id_kab')
                ->join('prov', 'prov.id', '=', 'kab.id_prov')
                ->where('pil.id', '=', $id_caleg)
                ->where('pil.status', '=', 'l')
                ->select('pil.*', 'kel.id as id_kel', 'kel.kel', 'kec.id as id_kec', 'kec.kec', 'kab.id as id_kab', 'kab.kab', 'prov.id as id_prov', 'prov.prov', 'partai.id as id_partai', 'partai.partai')
                ->first();

        return $data;
    }

    function updateProfile($data = array())
    {
        $id = $data['id'];
        $fname = $data['fname'];
    	$lname = $data['lname'];
    	$partai = $data['partai'];
    	$gender = $data['gender'];
    	$kec = $data['kec'];
    	$kel = $data['kel'];
    	$prov = $data['prov'];
    	$kab = $data['kab'];
    	$dapil = $data['dapil'];
    	$tingkat = $data['tingkat'];

    	$req = DB::select('CALL input_data_pil(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($id, $fname, $lname, $partai, $dapil, $prov, $kab, $kel, $tingkat, $gender));

    	return $req;

        return $req;
    }

    function getAllCaleg()
    {
        $data = DB::table('pil')
                ->join('partai', 'partai.id', '=', 'pil.id_partai')
                ->join('kel', 'kel.id', '=', 'pil.id_kel')
                ->join('kec', 'kec.id', '=', 'kel.id_kec')
                ->where('pil.status', '=', 'l')
                ->select('pil.*', 'kel.id as id_kel', 'kel.kel', 'kec.id as id_kec', 'kec.kec', 'partai.id as id_partai', 'partai.partai')
                ->paginate('10');
        return $data;
    }

    function deleteCaleg($id_caleg)
    {
        $req = DB::select('CALL delete_data_pil(?)', array($id_caleg));

        return $req;
    }
}
