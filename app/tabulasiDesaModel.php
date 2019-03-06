<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class tabulasiDesaModel extends Model
{
    function tabulasiPartaiByKel($id_kel, $tingkat)
    {
        $data = DB::table('suara_desa as suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'kel.id as id_kel', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
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
        $data = DB::table('suara_desa as suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'kel.id as id_kel', 'suara.jenis_suara', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg', 'pil.no_urut')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->whereIn('suara.id_partai', $id_partai)
                ->where('kel.id', '=', $id_kel)
                ->groupBy('suara.id_caleg', 'kel.id')
                ->orderBy('pil.no_urut', 'asc')
                ->get();

        return $data;
    }

    function tabulasiPartaiByKec($id_kec, $tingkat)
    {
        $data = DB::table('suara_desa as suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'kel.id as id_kel', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->join('kec', 'kec.id', '=', 'kel.id_kec')
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
        $data = DB::table('suara_desa as suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'kel.id as id_kel', 'suara.jenis_suara', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg', 'pil.no_urut')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->join('kec', 'kec.id', '=', 'kel.id_kec')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->whereIn('suara.id_partai', $id_partai)
                ->where('kec.id', '=', $id_kec)
                ->groupBy('suara.id_caleg', 'kec.id')
                ->orderBy('pil.no_urut', 'asc')
                ->get();

        return $data;
    }

    function tabulasiPartaiByKab($id_kab, $tingkat)
    {
        $data = DB::table('suara_desa as suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'kel.id as id_kel', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->join('kab', 'kab.id', '=', 'kel.id_kab')
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
        $data = DB::table('suara_desa as suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'kel.id as id_kel', 'suara.jenis_suara', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg', 'pil.no_urut')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->join('kab', 'kab.id', '=', 'kel.id_kab')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->whereIn('suara.id_partai', $id_partai)
                ->where('kab.id', '=', $id_kab)
                ->groupBy('suara.id_caleg', 'kab.id')
                ->orderBy('pil.no_urut', 'asc')
                ->get();

        return $data;
    }

    function tabulasiPartaiByProv($id_prov, $tingkat)
    {
        $data = DB::table('suara_desa as suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'kel.id as id_kel', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->join('prov', 'prov.id', '=', 'kel.id_prov')
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
        $data = DB::table('suara_desa as suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'kel.id as id_kel', 'suara.jenis_suara', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg', 'pil.no_urut')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->join('prov', 'prov.id', '=', 'kel.id_prov')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->whereIn('suara.id_partai', $id_partai)
                ->where('prov.id', '=', $id_prov)
                ->groupBy('suara.id_caleg', 'prov.id')
                ->orderBy('pil.no_urut', 'asc')
                ->get();

        return $data;
    }

    function tabulasiPartaiByDapil($id_dapil, $tingkat)
    {
        $data = DB::table('suara_desa as suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'kel.id as id_kel', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->join('kec', 'kec.id', '=', 'kel.id_kec')
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
        $data = DB::table('suara_desa as suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'kel.id as id_kel', 'suara.jenis_suara', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg', 'pil.no_urut')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->join('kec', 'kec.id', '=', 'kel.id_kec')
                ->join('dapil', 'dapil.id', '=', 'kec.id_dapil')
                ->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->whereIn('suara.id_partai', $id_partai)
                ->where('dapil.id', '=', $id_dapil)
                ->groupBy('suara.id_caleg', 'dapil.id')
                ->orderBy('pil.no_urut', 'asc')
                ->get();

        return $data;
    }

    function tabulasiPartaiByDapilKab($id_dapil, $tingkat)
    {
        $data = DB::table('suara_desa as suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'kel.id as id_kel', 'suara.jenis_suara')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->join('kab', 'kab.id', '=', 'kel.id_kab');
                if($tingkat == 'c')
                {
                    $data->join('dapil', 'dapil.id', '=', 'kab.dapil_dprri');
                }
                if($tingkat == 'd')
                {
                    $data->join('dapil', 'dapil.id', '=', 'kab.dapil_dprprov');
                }               
         $res = $data->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'p')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->where('dapil.id', '=', $id_dapil)
                ->groupBy('suara.id_partai', 'dapil.id')
                ->get();

        return $res;
    }

    function tabulasiCalegByDapilKab($id_partai, $id_dapil, $tingkat)
    {
        $data = DB::table('suara_desa as suara')
                ->select('suara.id', 'partai.id as id_partai', 'partai.partai', DB::raw('SUM(suara.suara) as total_suara'), 'kel.id as id_kel', 'suara.jenis_suara', 'pil.nama_depan as nama_depan_caleg', 'pil.nama_belakang as nama_belakang_caleg', 'pil.no_urut')
                ->join('pil', 'pil.id', '=', 'suara.id_caleg')
                ->join('partai', 'partai.id', '=', 'suara.id_partai')
                ->join('kel', 'kel.id', '=', 'suara.id_kel')
                ->join('kab', 'kab.id', '=', 'kel.id_kab');
                if($tingkat == 'c')
                {
                    $data->join('dapil', 'dapil.id', '=', 'kab.dapil_dprri');
                }
                if($tingkat == 'd')
                {
                    $data->join('dapil', 'dapil.id', '=', 'kab.dapil_dprprov');
                }
        $res = $data->where('suara.status', '=', 'l')
                ->where('suara.jenis_suara', '=', 'c')
                ->where('suara.tingkat_suara', '=', $tingkat)
                ->whereIn('suara.id_partai', $id_partai)
                ->where('dapil.id', '=', $id_dapil)
                ->groupBy('suara.id_caleg', 'dapil.id')
                ->orderBy('pil.no_urut', 'asc')
                ->get();

        return $res;
    }
}
