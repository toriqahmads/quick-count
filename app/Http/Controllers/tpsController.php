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
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new dataModel();
	    	$kec = $data->getKec(1);
	    	
	    	return view('admin.tps.register', compact('kec'));
	    }
    }

    function registerPostTps(Request $request)
    {
        $this->validate($request, [
            'tps' => 'required|min:4|max:10',
            'kec' => 'required|min:1|max:3',
            'kel' => 'required|min:1|max:3',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:3',
            'dapil' => 'required|min:1|max:2',
        ],[
            'tps.required'=>'Nama depan tidak boleh kosong!',
            'tps.min'=>'Maaf Nama depan minimal 4 karakter!',
            'tps.max'=>'Maaf Nama depan maximal 15 karakter!',
            'kec.required' => 'Kecapatan tidak boleh kosong!',
            'kel.required' => 'Kelurahan tidak boleh kosong!',
            'prov.required' => 'Provinsi tidak boleh kosong',
            'kab.required' => 'Kabupaten tidak boleh kosong',
            'dapil.required' => 'Dapil tidak boleh kosong',
        ]);
        $data = ['tps' => $request->tps,
                'kec' => $request->kec,
                'kel' => $request->kel,
                'prov' => $request->prov,
                'kab' => $request->kab,
                'dapil' => $request->dapil
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
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new tpsModel();
    		$req = $req->getAllTps();

    		return view('admin.tps.userlist', compact('req'));
	    }
    }

    function editTps($id_tps)
    {
	    if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new tpsModel();
	    	$data = $data->getProfile($id_tps);
	    	$kecamatan = new dataModel();
	    	$kecs = $kecamatan->getKec(1);
	    	$kels = $kecamatan->getKel($data->id_kec);
	    	return view('admin.tps.edit', compact('data', 'kecs', 'kels'));
	    }
    }

    function updateTps(Request $request)
    {
        $this->validate($request, [
        	'id' => 'required|min:1|max:4',
            'tps' => 'required|min:4|max:10',
            'kec' => 'required|min:1|max:3',
            'kel' => 'required|min:1|max:3',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:3',
            'dapil' => 'required|min:1|max:2',
        ],[
            'tps.required'=>'Nama depan tidak boleh kosong!',
            'tps.min'=>'Maaf Nama depan minimal 4 karakter!',
            'tps.max'=>'Maaf Nama depan maximal 15 karakter!',
            'kec.required' => 'Kecapatan tidak boleh kosong!',
            'kel.required' => 'Kelurahan tidak boleh kosong!',
            'prov.required' => 'Provinsi tidak boleh kosong',
            'kab.required' => 'Kabupaten tidak boleh kosong',
            'dapil.required' => 'Dapil tidak boleh kosong',
        ]);
        $data = ['id' => $request->id,
        		'tps' => $request->tps,
                'kec' => $request->kec,
                'kel' => $request->kel,
                'prov' => $request->prov,
                'kab' => $request->kab,
                'dapil' => $request->dapil
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
	    if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new tpsModel();
	    	$data = $data->getProfile($id_tps);
	    	$kecamatan = new dataModel();
	    	$kecs = $kecamatan->getKec(1);
	    	$kels = $kecamatan->getKel($data->id_kec);
	    	return view('admin.tps.view', compact('data', 'kecs', 'kels'));
	    }
    }

    function deleteTps($id_tps)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new tpsModel();
	    	$req = $data->deleteTps($id_tps);
	    	#$req->delete();
        	return $req;
    	}
	}
}
