<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class partaiModel extends Model
{
    function registerPost($data = array())
    {
    	$partai = $data['partai'];
        $foto = $data['foto'];

    	$req = DB::table('partai')->insertGetId(
		    ['partai' => $partai, 'foto' => $foto]
		);

    	return $req;
    }

    function getAllPartai()
    {
        $data = DB::table('partai')
                ->select('partai.*')
                ->paginate('10');
        return $data;
    }

    function getProfile($id_partai)
    {
        $data = DB::table('partai')
                ->where('partai.id', '=', $id_partai)
                ->select('partai.*')
                ->first();

        return $data;
    }

    function updateProfile($data = array())
    {
        $id = $data['id'];
    	$partai = $data['partai'];
        $foto = $data['foto'];

    	$req = DB::table('partai')
            ->where('id', $id)
            ->update(['partai' => $partai, 'foto' => $foto]);

        return $req;
    }

    function deletePartai($id_partai)
    {
        $req = DB::table('partai')
                ->where('partai.id', '=', $id_partai)
                ->delete();

        return $req;
    }

}
