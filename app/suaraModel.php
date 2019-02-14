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
        $tingkat = $data['tingkat'];
    	$id_partai = $data['partai'];

    	$req = DB::select('CALL input_suara(?, ?, ?, ?, ?, ?, ?)', array($suara, $id_caleg, $id_saksi, $id_tps, $jenis, $id_partai, $tingkat));

    	return $req;
    }

    function getAllSuaraPartai($id_partai, $id_tps, $tingkat)
    {
        $data = DB::table('suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('saksi', 'saksi.id', '=', 'suara.id_saksi')
                ->where('suara.id_tps', '=', $id_tps)
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->orderBy('partai.no_urut', 'asc')
                ->select('suara.id', 'partai.no_urut', 'suara.suara as jumlah_suara', 'suara.id_saksi', 'saksi.nama_depan as nama_depan_saksi', 'saksi.nama_belakang as nama_belakang_saksi', 'partai.id as id_partai', 'partai.partai', 'tps.id as id_tps', 'tps.tps', 'suara.jenis_suara', 'suara.tingkat_suara')
                ->get();

        return $data;
    }

    function getAllSuaraPartaiBySaksi($id_partai, $id_tps, $id_saksi, $tingkat)
    {
        $data = DB::table('suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('saksi', 'saksi.id', '=', 'suara.id_saksi')
                ->where('suara.id_tps', '=', $id_tps)
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('suara.id_saksi', '=', $id_saksi)
                ->where('suara.tingkat_suara', '=', $tingkat) 
                ->orderBy('partai.no_urut', 'asc')
                ->select('suara.id', 'partai.no_urut', 'suara.suara as jumlah_suara', 'suara.id_saksi', 'saksi.nama_depan as nama_depan_saksi', 'saksi.nama_belakang as nama_belakang_saksi', 'partai.id as id_partai', 'partai.partai', 'tps.id as id_tps', 'tps.tps', 'suara.jenis_suara', 'suara.tingkat_suara')
                ->get();

        return $data;
    }

    function getAllSuaraCaleg($id_partai, $id_tps, $tingkat)
    {
        $data = DB::table('suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('saksi', 'saksi.id', '=', 'suara.id_saksi')
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('suara.id_tps', '=', $id_tps)
                ->orderBy('pil.no_urut', 'asc')
                ->select('suara.id', 'pil.no_urut', 'suara.suara as jumlah_suara', 'suara.id_saksi', 'saksi.nama_depan as nama_depan_saksi', 'saksi.nama_belakang as nama_belakang_saksi', 'partai.id as id_partai', 'partai.partai', 'pil.id as id_caleg', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg', 'tps.id as id_tps', 'tps.tps', 'suara.jenis_suara', 'suara.tingkat_suara')
                ->get();

        return $data;
    }

    function getAllSuaraCalegBySaksi($id_partai, $id_tps, $id_saksi, $tingkat)
    {
        $data = DB::table('suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('saksi', 'saksi.id', '=', 'suara.id_saksi')
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('suara.id_saksi', '=', $id_saksi)
                ->select('suara.id', 'pil.no_urut', 'suara.suara as jumlah_suara', 'suara.id_saksi', 'saksi.nama_depan as nama_depan_saksi', 'saksi.nama_belakang as nama_belakang_saksi', 'partai.id as id_partai', 'partai.partai', 'pil.id as id_caleg', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg', 'tps.id as id_tps', 'tps.tps', 'suara.jenis_suara', 'suara.tingkat_suara')
                ->orderBy('pil.no_urut', 'asc')
                ->get();

        return $data;
    }

    function updateSuara($data = array())
    {
        $id = $data['id'];
        $suara = $data['suara'];
        $id_caleg = $data['caleg'];
        $id_saksi = $data['saksi'];
        $id_tps = $data['tps'];
        $jenis = $data['jenis'];
        $id_partai = $data['partai'];
        $tingkat = $data['tingkat'];

        $req = DB::select('CALL update_suara(?, ?, ?, ?, ?, ?, ?, ?)', array($id, $suara, $id_caleg, $id_saksi, $id_tps, $jenis, $id_partai, $tingkat));

        return $req;
    }

    function deleteSuara($data = array())
    {
        $id = $data['id'];

        $req = DB::select('CALL delete_suara(?)', array($id));

        return $req;
    }
}
