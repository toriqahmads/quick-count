<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class suaraDesaModel extends Model
{
    function registerPost($data = array())
    {
        $suara = $data['suara'];
        $id_caleg = $data['caleg'];
        $id_saksi = $data['saksi'];
        $id_kel = $data['kel'];
        $jenis = $data['jenis'];
        $tingkat = $data['tingkat'];
        $id_partai = $data['partai'];

        $req = DB::select('CALL input_suara_desa(?, ?, ?, ?, ?, ?, ?)', array($suara, $id_caleg, $id_saksi, $id_kel, $jenis, $id_partai, $tingkat));

        return $req;
    }

    function getAllSuaraPartai($id_partai, $id_kel, $tingkat)
    {
        $data = DB::table('suara_desa as suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->where('suara.id_kel', '=', $id_kel)
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->orderBy('partai.no_urut', 'asc')
                ->select('suara.id', 'partai.no_urut', 'suara.suara as jumlah_suara', 'partai.id as id_partai', 'partai.partai', 'kel.id as id_kel', 'kel.kel', 'suara.jenis_suara', 'suara.tingkat_suara')
                ->get();

        return $data;
    }

    function getAllSuaraPartaiBySaksi($id_partai, $id_kel, $id_saksi, $tingkat)
    {
        $data = DB::table('suara_desa as suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->join('saksi', 'saksi.id', '=', 'suara.id_saksi')
                ->where('suara.id_kel', '=', $id_kel)
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('suara.id_saksi', '=', $id_saksi)
                ->where('suara.tingkat_suara', '=', $tingkat) 
                ->orderBy('partai.no_urut', 'asc')
                ->select('suara.id', 'partai.no_urut', 'suara.suara as jumlah_suara', 'suara.id_saksi', 'saksi.nama_depan as nama_depan_saksi', 'saksi.nama_belakang as nama_belakang_saksi', 'partai.id as id_partai', 'partai.partai', 'kel.id as id_kel', 'kel.kel', 'suara.jenis_suara', 'suara.tingkat_suara')
                ->get();

        return $data;
    }

    function getAllSuaraCaleg($id_partai, $id_kel, $tingkat)
    {
        $data = DB::table('suara_desa as suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('suara.id_kel', '=', $id_kel)
                ->orderBy('pil.no_urut', 'asc')
                ->select('suara.id', 'pil.no_urut', 'suara.suara as jumlah_suara', 'partai.id as id_partai', 'partai.partai', 'pil.id as id_caleg', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg', 'kel.id as id_kel', 'kel.kel', 'suara.jenis_suara', 'suara.tingkat_suara')
                ->get();

        return $data;
    }

    function getAllSuaraCalegBySaksi($id_partai, $id_kel, $id_saksi, $tingkat)
    {
        $data = DB::table('suara_desa as suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('saksi', 'saksi.id', '=', 'suara.id_saksi')
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('suara.id_saksi', '=', $id_saksi)
                ->select('suara.id', 'pil.no_urut', 'suara.suara as jumlah_suara', 'suara.id_saksi', 'saksi.nama_depan as nama_depan_saksi', 'saksi.nama_belakang as nama_belakang_saksi', 'partai.id as id_partai', 'partai.partai', 'pil.id as id_caleg', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg', 'kel.id as id_kel', 'kel.kel', 'suara.jenis_suara', 'suara.tingkat_suara')
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
        $id_kel = $data['kel'];
        $jenis = $data['jenis'];
        $id_partai = $data['partai'];
        $tingkat = $data['tingkat'];

        $req = DB::select('CALL update_suara_desa(?, ?, ?, ?, ?, ?, ?, ?)', array($id, $suara, $id_caleg, $id_saksi, $id_kel, $jenis, $id_partai, $tingkat));

        return $req;
    }

    function deleteSuara($data = array())
    {
        $id = $data['id'];

        $req = DB::select('CALL delete_suara_desa(?)', array($id));

        return $req;
    }
}
