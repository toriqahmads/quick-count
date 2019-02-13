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

    function tabulasiPartaiByKab($id_kab, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('kab', 'kab.id', '=', 'tps.id_kab')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('kab.id', '=', $id_kab)
                ->groupBy('suara.id_partai', 'kab.id')
                ->get();

        return $data;
    }

    function tabulasiCalegByKab($id_partai, $id_kab, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('kab', 'kab.id', '=', 'tps.id_kab')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('suara.id_partai', '=', $id_partai)
                ->where('kab.id', '=', $id_kab)
                ->groupBy('suara.id_caleg', 'kab.id')
                ->get();

        return $data;
    }

    function tabulasiPartaiByProv($id_prov, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('prov', 'prov.id', '=', 'tps.id_prov')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('prov.id', '=', $id_prov)
                ->groupBy('suara.id_partai', 'prov.id')
                ->get();

        return $data;
    }

    function tabulasiCalegByProv($id_partai, $id_prov, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('prov', 'prov.id', '=', 'tps.id_prov')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('suara.id_partai', '=', $id_partai)
                ->where('prov.id', '=', $id_prov)
                ->groupBy('suara.id_caleg', 'prov.id')
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

    function tabulasiPartaiByDapilKab($id_dapil, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('kab', 'kab.id', '=', 'tps.id_kab')
                ->join('dapil', 'dapil.id', '=', 'kab.id_dapil')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('dapil.id', '=', $id_dapil)
                ->groupBy('suara.id_partai', 'dapil.id')
                ->get();

        return $data;
    }

    function tabulasiCalegByDapilKab($id_partai, $id_dapil, $tingkat)
    {
        $data = DB::table('suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'tps.id as id_tps', 'suara.jenis_suara', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('tps', 'tps.id', '=', 'suara.id_tps')
                ->join('kab', 'kab.id', '=', 'tps.id_kab')
                ->join('dapil', 'dapil.id', '=', 'kab.id_dapil')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('suara.id_partai', '=', $id_partai)
                ->where('dapil.id', '=', $id_dapil)
                ->groupBy('suara.id_caleg', 'dapil.id')
                ->get();

        return $data;
    }
}
