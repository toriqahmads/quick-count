<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\adminModel;
use App\dataModel;
use App\saksiModel;
use App\calegModel;
use App\tpsModel;
use App\partaiModel;
use App\suaraModel;

class tpsController extends Controller
{
    function registerTps()
    {
    	$data = new dataModel();
    	$data = $data->getProv();
    	
    	return view('admin.tps.register', compact('data'));
    }

    function registerPostTps(Request $request)
    {
        $this->validate($request, [
            'tps' => 'required|min:4|max:10',
            'kec' => 'required|min:1',
            'kel' => 'required|min:1',
            'prov' => 'required|min:1',
            'kab' => 'required|min:1',
        ],[
            'tps.required'=>'Nama depan tidak boleh kosong!',
            'tps.min'=>'Maaf Nama depan minimal 4 karakter!',
            'tps.max'=>'Maaf Nama depan maximal 15 karakter!',
            'kec.required' => 'Kecapatan tidak boleh kosong!',
            'kel.required' => 'Kelurahan tidak boleh kosong!',
            'prov.required' => 'Provinsi tidak boleh kosong',
            'kab.required' => 'Kabupaten tidak boleh kosong',
        ]);
        $data = ['tps' => $request->tps,
                'kec' => $request->kec,
                'kel' => $request->kel,
                'prov' => $request->prov,
                'kab' => $request->kab,
            	];

        $req = new tpsModel();
        $req = $req->registerPost($data);
        $req = json_decode(json_encode($req), true);
        if($req[0]['msg'] == "success")
        {
            return redirect()->back()->with('alert-success','Input TPS sukses!');
        }
        else
        {
            return redirect()->back()->with('alert','Input TPS gagal!');
        }
    }

    function getAllTps()
    {
    	$req = new tpsModel();
		$req = $req->getAllTps();

		return view('admin.tps.userlist', compact('req'));
    }

    function editTps($id_tps)
    {
    	$data = new tpsModel();
    	$data = $data->getProfile($id_tps);
    	$reg = new dataModel();
    	$prov = $reg->getProv();
        $kab = $reg->getKab($data->id_prov);
        $kec = $reg->getKec($data->id_kab);
        $kel = $reg->getKel($data->id_kec);
    	return view('admin.tps.edit', compact('data', 'prov', 'kab', 'kec', 'kel'));
    }

    function updateTps(Request $request)
    {
        $this->validate($request, [
        	'id' => 'required|min:1',
            'tps' => 'required|min:4|max:10',
            'kec' => 'required|min:1',
            'kel' => 'required|min:1',
            'prov' => 'required|min:1',
            'kab' => 'required|min:1',
        ],[
            'tps.required'=>'Nama depan tidak boleh kosong!',
            'tps.min'=>'Maaf Nama depan minimal 4 karakter!',
            'tps.max'=>'Maaf Nama depan maximal 15 karakter!',
            'kec.required' => 'Kecapatan tidak boleh kosong!',
            'kel.required' => 'Kelurahan tidak boleh kosong!',
            'prov.required' => 'Provinsi tidak boleh kosong',
            'kab.required' => 'Kabupaten tidak boleh kosong',
        ]);
        $data = ['id' => $request->id,
        		'tps' => $request->tps,
                'kec' => $request->kec,
                'kel' => $request->kel,
                'prov' => $request->prov,
                'kab' => $request->kab,
            	];

        $req = new tpsModel();
        $req = $req->updateProfile($data);
        $req = json_decode(json_encode($req), true);
        if($req[0]['msg'] == "success")
        {
            return redirect()->back()->with('alert-success','Update data TPS sukses!');
        }
        else
        {
            return redirect()->back()->with('alert','Update data TPS gagal!');
        }
    }

    function viewTps($id_tps)
    {
    	$data = new tpsModel();
    	$data = $data->getProfile($id_tps);
    	$kecamatan = new dataModel();
    	$kecs = $kecamatan->getKec(1);
    	$kels = $kecamatan->getKel($data->id_kec);
    	return view('admin.tps.view', compact('data', 'kecs', 'kels'));
    }

    function deleteTps($id_tps)
    {
    	$data = new tpsModel();
    	$req = $data->deleteTps($id_tps);
    	return $req;
	}
}
