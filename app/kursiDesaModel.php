<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class kursiDesaModel extends Model
{
    function getVote($id_dapil, $tingkat)
    {
    	$data = DB::table('suara_desa as suara')
                ->select(DB::raw('SUM(suara.suara) as total_suara'), 'partai.partai')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel');
                if($tingkat == 'e')
                {
                	$data->join('kec', 'kec.id', '=', 'kel.id_kec')->join('dapil', 'dapil.id', '=', 'kec.id_dapil');
                }
                if($tingkat == 'd' || $tingkat == 'c')
                {
                	$data->join('kab', 'kab.id', '=', 'kel.id_kab')->join('dapil', 'dapil.id', '=', 'kab.id_dapil');
                }
                
        $res = $data->where('suara.status', '=', 'l')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('dapil.id', '=', $id_dapil)
                ->groupBy('suara.id_partai', 'dapil.id')
                ->orderBy('partai.no_urut', 'asc')
                ->get();

        return $res;
    }

    function getKursi($id_dapil)
    {
        $data = DB::table('dapil')
                ->select('dapil.kursi')
                ->where('dapil.id', '=', $id_dapil)
                ->first();

        return $data;
    }

    function getWinner($id_dapil, $tingkat, $id_partai, $limit)
    {
        $data = DB::table('suara_desa as suara')
                ->select('pil.id as id_caleg', 'pil.nama_depan', 'pil.nama_belakang', 'partai.id as id_partai','partai.partai', DB::raw('SUM(suara.suara) as total_suara'))
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('kel', 'kel.id', '=', 'suara.id_kel');
                if($tingkat == 'e')
                {
                    $data->join('kec', 'kec.id', '=', 'kel.id_kec')->join('dapil', 'dapil.id', '=', 'kec.id_dapil');
                }
                if($tingkat == 'd' || $tingkat == 'c')
                {
                    $data->join('kab', 'kab.id', '=', 'kel.id_kab')->join('dapil', 'dapil.id', '=', 'kab.id_dapil');
                }
                
        $res = $data->where('suara.status', '=', 'l')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('suara.jenis_suara', '=', 'c')
                ->where('dapil.id', '=', $id_dapil)
                ->where('partai.id', '=', $id_partai)
                ->groupBy('suara.id_caleg', 'dapil.id')
                ->orderBy('total_suara', 'dsc')
                ->limit($limit)
                ->get();

        return $res;
    }
}
