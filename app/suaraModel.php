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

    function getAllSuaraPartai($id_dapil, $id_partai, $id_tps)
    {
        $data = DB::table('suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('dapil', 'dapil.id', '=', 'tps.id_dapil')
                ->join('saksi', 'saksi.id', '=', 'suara.id_saksi')
                ->where('suara.id_tps', '=', $id_tps)
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('dapil.id', '=', $id_dapil)
                ->select('suara.id', 'suara.suara as jumlah_suara', 'suara.id_saksi', 'saksi.nama_depan as nama_depan_saksi', 'saksi.nama_belakang as nama_belakang_saksi', 'partai.id as id_partai', 'partai.partai', 'tps.id as id_tps', 'tps.tps', 'suara.jenis_suara')
                ->get();

        return $data;
    }

    function getAllSuaraPartaiBySaksi($id_dapil, $id_partai, $id_tps, $id_saksi)
    {
        $data = DB::table('suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('dapil', 'dapil.id', '=', 'tps.id_dapil')
                ->join('saksi', 'saksi.id', '=', 'suara.id_saksi')
                ->where('suara.id_tps', '=', $id_tps)
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('dapil.id', '=', $id_dapil)
                ->where('suara.id_saksi', '=', $id_saksi)
                ->select('suara.id', 'suara.suara as jumlah_suara', 'suara.id_saksi', 'saksi.nama_depan as nama_depan_saksi', 'saksi.nama_belakang as nama_belakang_saksi', 'partai.id as id_partai', 'partai.partai', 'tps.id as id_tps', 'tps.tps', 'suara.jenis_suara')
                ->get();

        return $data;
    }

    function getAllSuaraPartaiByDapil($id_dapil, $id_partai)
    {
        //SELECT id_partai, suara, sum(suara) as total_suara from suara as s join tps on tps.id = s.id_tps join dapil on dapil.id = tps.id_dapil where dapil.id = 1 AND s.jenis_suara = "p" GROUP BY s.id_partai
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'dapil.id as id_dapil', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('dapil', 'dapil.id', '=', 'tps.id_dapil')
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('dapil.id', '=', $id_dapil)
                ->groupBy('suara.id_partai')
                ->get();

        return $data;
    }

    function getAllSuaraPartaiForChartByDapil($id_dapil)
    {
        //SELECT id_partai, suara, sum(suara) as total_suara from suara as s join tps on tps.id = s.id_tps join dapil on dapil.id = tps.id_dapil where dapil.id = 1 AND s.jenis_suara = "p" GROUP BY s.id_partai
        $data = DB::table('suara')
                ->select('partai.partai as name', DB::raw('SUM(suara.suara) as data'))
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('dapil', 'dapil.id', '=', 'tps.id_dapil')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('dapil.id', '=', $id_dapil)
                ->groupBy('suara.id_partai')
                ->get();

        return $data;
    }

    function getAllSuaraPartaiForChartByTps($id_dapil, $id_tps)
    {
        //SELECT id_partai, suara, sum(suara) as total_suara from suara as s join tps on tps.id = s.id_tps join dapil on dapil.id = tps.id_dapil where dapil.id = 1 AND s.jenis_suara = "p" GROUP BY s.id_partai
        $data = DB::table('suara')
                ->select('partai.partai as name', DB::raw('SUM(suara.suara) as data'))
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('dapil', 'dapil.id', '=', 'tps.id_dapil')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('dapil.id', '=', $id_dapil)
                ->where('tps.id', '=', $id_tps)
                ->groupBy('suara.id_partai')
                ->get();

        return $data;
    }

    function getAllSuaraCaleg($id_dapil, $id_partai, $id_tps)
    {
        $data = DB::table('suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('dapil', 'dapil.id', '=', 'tps.id_dapil')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('saksi', 'saksi.id', '=', 'suara.id_saksi')
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('dapil.id', '=', $id_dapil)
                ->select('suara.id', 'suara.suara as jumlah_suara', 'suara.id_saksi', 'saksi.nama_depan as nama_depan_saksi', 'saksi.nama_belakang as nama_belakang_saksi', 'partai.id as id_partai', 'partai.partai', 'pil.id as id_caleg', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg', 'tps.id as id_tps', 'tps.tps', 'suara.jenis_suara')
                ->get();

        return $data;
    }

    function getAllSuaraCalegBySaksi($id_dapil, $id_partai, $id_tps, $id_saksi)
    {
        $data = DB::table('suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('dapil', 'dapil.id', '=', 'tps.id_dapil')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('saksi', 'saksi.id', '=', 'suara.id_saksi')
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('dapil.id', '=', $id_dapil)
                ->where('suara.id_saksi', '=', $id_saksi)
                ->select('suara.id', 'suara.suara as jumlah_suara', 'suara.id_saksi', 'saksi.nama_depan as nama_depan_saksi', 'saksi.nama_belakang as nama_belakang_saksi', 'partai.id as id_partai', 'partai.partai', 'pil.id as id_caleg', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg', 'tps.id as id_tps', 'tps.tps', 'suara.jenis_suara')
                ->get();

        return $data;
    }

    function getAllSuaraCalegByDapil($id_dapil, $id_partai)
    {
        //SELECT id_partai, suara, sum(suara) as total_suara from suara as s join tps on tps.id = s.id_tps join dapil on dapil.id = tps.id_dapil where dapil.id = 1 AND s.jenis_suara = "p" GROUP BY s.id_partai
        $data = DB::table('suara')
                ->select('suara.id', 'pil.id as id_caleg', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg', DB::raw('SUM(suara.suara) as total_suara'), 'partai.id as id_partai', 'partai.partai', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('dapil', 'dapil.id', '=', 'tps.id_dapil')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('saksi', 'saksi.id', '=', 'suara.id_saksi')
                ->where('suara.id_partai', '=', $id_partai)
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('dapil.id', '=', $id_dapil)
                ->groupBy('suara.id_caleg')
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

        $req = DB::select('CALL update_suara(?, ?, ?, ?, ?, ?, ?)', array($id, $suara, $id_caleg, $id_saksi, $id_tps, $jenis, $id_partai));

        return $req;
    }

    function deleteSuara($data = array())
    {
        $id = $data['id'];

        $req = DB::select('CALL delete_suara(?)', array($id));

        return $req;
    }
}
