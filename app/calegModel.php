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
    	$dapil = $data['dapil'];
    	$tingkat = $data['tingkat'];
        $prov = $data['prov'];
        $kab = $data['kab'];
        $foto = $data['foto'];
        $no_urut = $data['no_urut'];
        $kec = $data['kec'];

    	$req = DB::select('CALL input_data_pil(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($fname, $lname, $partai, $dapil, $tingkat, $gender, $foto, $prov, $kab, $no_urut, $kec));

    	return $req;
    }

    function getProfile($id_caleg)
    {
        $data = DB::table('pil')
                ->select('pil.*', 'partai.id as id_partai', 'partai.partai')
                ->join('partai', 'partai.id', '=', 'pil.id_partai')
                ->where('pil.id', '=', $id_caleg)
                ->where('pil.status', '=', 'l')
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
        $prov = $data['prov'];
        $kab = $data['kab'];
        $no_urut = $data['no_urut'];
        $kec = $data['kec'];

    	$req = DB::select('CALL update_data_pil(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($id, $fname, $lname, $partai, $dapil, $tingkat, $gender, $foto, $prov, $kab, $no_urut, $kec));

        return $req;
    }

    function getAllCaleg()
    {
        $data = DB::table('pil')
                ->join('partai', 'partai.id', '=', 'pil.id_partai')
                ->where('pil.status', '=', 'l')
                ->select('pil.*', 'partai.id as id_partai', 'partai.partai')
                ->paginate('10');
        return $data;
    }

    function deleteCaleg($id_caleg)
    {
        $req = DB::select('CALL delete_data_pil(?)', array($id_caleg));

        return $req;
    }
}
