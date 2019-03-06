<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class kursiModel extends Model
{
    function getVote($id_dapil, $tingkat)
    {
    	$data = DB::table('suara')
                ->select(DB::raw('SUM(suara.suara) as total_suara'), 'partai.partai')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps');
                if($tingkat == 'e')
                {
                	$data->join('kec', 'kec.id', '=', 'tps.id_kec')->join('dapil', 'dapil.id', '=', 'kec.id_dapil');
                }
                if($tingkat == 'd')
                {
                    $data->join('kab', 'kab.id', '=', 'tps.id_kab')->join('dapil', 'dapil.id', '=', 'kab.dapil_dprprov');
                }
                if($tingkat == 'c')
                {
                    $data->join('kab', 'kab.id', '=', 'tps.id_kab')->join('dapil', 'dapil.id', '=', 'kab.dapil_dprri');
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
        $data = DB::table('suara')
                ->select('pil.id as id_caleg', 'pil.nama_depan', 'pil.nama_belakang', 'partai.id as id_partai','partai.partai', DB::raw('SUM(suara.suara) as total_suara'))
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('tps', 'tps.id', '=', 'suara.id_tps');
                if($tingkat == 'e')
                {
                    $data->join('kec', 'kec.id', '=', 'tps.id_kec')->join('dapil', 'dapil.id', '=', 'kec.id_dapil');
                }
                if($tingkat == 'd')
                {
                    $data->join('kab', 'kab.id', '=', 'tps.id_kab')->join('dapil', 'dapil.id', '=', 'kab.dapil_dprprov');
                }
                if($tingkat == 'c')
                {
                    $data->join('kab', 'kab.id', '=', 'tps.id_kab')->join('dapil', 'dapil.id', '=', 'kab.dapil_dprri');
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
