<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class tabulasiModel extends Model
{
    function tabulasiPartaiByTps($id_tps, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('tps.id', '=', $id_tps)
                ->groupBy('suara.id_partai', 'tps.id')
                ->get();

        return $data;
    }

    function tabulasiCalegByTps($id_partai, $id_tps, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('suara.id_partai', '=', $id_partai)
                ->where('tps.id', '=', $id_tps)
                ->groupBy('suara.id_caleg', 'tps.id')
                ->get();

        return $data;
    }

    function tabulasiPartaiByKel($id_kel, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('kel', 'kel.id', '=', 'tps.id_kel')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('kel.id', '=', $id_kel)
                ->groupBy('suara.id_partai', 'kel.id')
                ->get();

        return $data;
    }

    function tabulasiCalegByKel($id_partai, $id_kel, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('kel', 'kel.id', '=', 'tps.id_kel')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('suara.id_partai', '=', $id_partai)
                ->where('kel.id', '=', $id_kel)
                ->groupBy('suara.id_caleg', 'kel.id')
                ->get();

        return $data;
    }

    function tabulasiPartaiByKec($id_kec, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('kec', 'kec.id', '=', 'tps.id_kec')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('kec.id', '=', $id_kec)
                ->groupBy('suara.id_partai', 'kec.id')
                ->get();

        return $data;
    }

    function tabulasiCalegByKec($id_partai, $id_kec, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('kec', 'kec.id', '=', 'tps.id_kec')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('suara.id_partai', '=', $id_partai)
                ->where('kec.id', '=', $id_kec)
                ->groupBy('suara.id_caleg', 'kec.id')
                ->get();

        return $data;
    }

    function tabulasiPartaiByDapil($id_dapil, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('kec', 'kec.id', '=', 'tps.id_kec')
                ->join('dapil', 'dapil.id', '=', 'kec.id_dapil')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('dapil.id', '=', $id_dapil)
                ->groupBy('suara.id_partai', 'dapil.id')
                ->get();

        return $data;
    }

    function tabulasiCalegByDapil($id_partai, $id_dapil, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('kec', 'kec.id', '=', 'tps.id_kec')
                ->join('dapil', 'dapil.id', '=', 'kec.id_dapil')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('suara.id_partai', '=', $id_partai)
                ->where('dapil.id', '=', $id_dapil)
                ->groupBy('suara.id_caleg', 'dapil.id')
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
}
