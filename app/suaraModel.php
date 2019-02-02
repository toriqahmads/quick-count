<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class suaraModel extends Model
{
    function registerPost($data = array())
    {
    	$suara = $data['suara'];
    	$id_caleg = $data['caleg'];
    	$id_saksi = $data['saksi'];
    	$id_tps = $data['tps'];
    	$jenis = $data['jenis'];
    	$id_partai = $data['partai'];

    	$req = DB::select('CALL input_suara(?, ?, ?, ?, ?, ?)', array($suara, $id_caleg, $id_saksi, $id_tps, $jenis, $id_partai));

    	return $req;
    }

    function getProfile($id_caleg)
    {
        $data = DB::table('pil')
                ->join('partai', 'partai.id', '=', 'pil.id_partai')
                ->join('dapil', 'dapil.id', '=', 'pil.id_dapil')
                ->where('pil.id', '=', $id_caleg)
                ->where('pil.status', '=', 'l')
                ->select('pil.*', 'partai.id as id_partai', 'partai.partai')
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
    	$dapil = $data['dapil'];
    	$tingkat = $data['tingkat'];
        $foto = $data['foto'];

    	$req = DB::select('CALL update_data_pil(?, ?, ?, ?, ?, ?, ?, ?)', array($id, $fname, $lname, $partai, $dapil, $tingkat, $gender, $foto));

        return $req;
    }

    function getAllCaleg($dapil, $partai)
    {
        $data = DB::table('pil')
                ->join('partai', 'partai.id', '=', 'pil.id_partai')
                ->join('dapil', 'dapil.id', '=', 'pil.id_dapil')
                ->where('pil.status', '=', 'l')
                ->select('pil.*', 'partai.id as id_partai', 'partai.partai')
                ->get();
        return $data;
    }

    function deleteCaleg($id_caleg)
    {
        $req = DB::select('CALL delete_data_pil(?)', array($id_caleg));

        return $req;
    }
}
