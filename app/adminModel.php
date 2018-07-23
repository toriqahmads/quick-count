<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class adminModel extends Model
{
    function cekLogin($username)
    {
    	$data = DB::table('admin')
    			->select('admin.*')
    			->where('admin.username', $username)
    			->first();
    				
    	return $data;
    }

    function registerPost($data = array())
    {
    	$fname = $data['fname'];
    	$lname = $data['lname'];
    	$nik = $data['nik'];
    	$telp = $data['telp'];
    	$gender = $data['gender'];
    	$alamat = $data['alamat'];
    	$kec = $data['kec'];
    	$kel = $data['kel'];
    	$tps = $data['tps'];
    	$prov = $data['prov'];
    	$kab = $data['kab'];
    	$dapil = $data['dapil'];
    	$pass = $data['password'];

    	$req = DB::select('CALL input_data_saksi(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($fname, $lname, $gender, $alamat, $kel, $kec, $kab, $prov, $dapil, $nik, $telp, $tps, $pass));

    	return $req;
    }

    function getProfile($nik, $id_saksi)
    {
        $data = DB::table('users')
                ->join('saksi', 'saksi.id', '=', 'users.id_saksi')
                ->join('kel', 'kel.id', '=', 'saksi.id_kel')
                ->join('kec', 'kec.id', '=', 'saksi.id_kec')
                ->join('kab', 'kab.id', '=', 'saksi.id_kab')
                ->join('prov', 'prov.id', '=', 'saksi.id_prov')
                ->join('tps', 'tps.id', '=', 'saksi.id_tps')
                ->join('dapil', 'dapil.id', '=', 'saksi.id_dapil')
                ->select('saksi.*', 'kel.id as id_kel', 'kel.kel', 'kec.id as id_kec', 'kec.kec', 'kab.id as id_kab', 'kab.kab', 'prov.id as id_prov', 'prov.prov', 'dapil.id as id_dapil', 'tps.id as id_tps', 'tps.tps')
                ->where('users.username', $nik)
                ->where('users.status', 'l')
                ->where('saksi.nik', $nik)
                ->where('saksi.status', 'l')
                ->first();

        return $data;
    }

    function updateProfile($data = array())
    {
        $id = $data['id'];
        $fname = $data['fname'];
        $lname = $data['lname'];
        $nik = $data['nik'];
        $telp = $data['telp'];
        $gender = $data['gender'];
        $alamat = $data['alamat'];
        $kec = $data['kec'];
        $kel = $data['kel'];
        $tps = $data['tps'];
        $prov = $data['prov'];
        $kab = $data['kab'];
        $dapil = $data['dapil'];

        $req = DB::select('CALL update_data_saksi(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($id, $fname, $lname, $gender, $alamat, $kel, $kec, $kab, $prov, $dapil, $nik, $telp, $tps));

        return $req;
    }

    function getAllSaksi()
    {
        $data = DB::table('saksi')
                ->join('users', 'saksi.id', '=', 'id_saksi')
                ->join('kel', 'kel.id', '=', 'saksi.id_kel')
                ->join('kec', 'kec.id', '=', 'saksi.id_kec')
                ->join('tps', 'tps.id', '=', 'saksi.id_tps')
                ->where('saksi.status', '=', 'l')
                ->where('users.status', '=', 'l')
                ->select('saksi.*', 'kel.id as id_kel', 'kel.kel', 'kec.id as id_kec', 'kec.kec', 'tps.id as id_tps', 'tps.tps')
                ->paginate('10');
        return $data;
    }

    function deleteSaksi($nik, $id_saksi)
    {
        $req = DB::select('CALL delete_data_saksi(?,?)', array($id_saksi, $nik));

        return $req;
    }
}
