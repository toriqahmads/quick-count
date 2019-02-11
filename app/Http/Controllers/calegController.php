<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\dataModel;
use App\saksiModel;
use App\calegModel;
use App\tpsModel;
use App\partaiModel;
use App\suaraModel;

class calegController extends Controller
{
    function registerCaleg()
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
	    	$partai = $data->getPartai();
	    	return view('admin.caleg.register', compact('partai'));
	    }
    }

    function registerPostCaleg(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required|min:2|max:15',
            'lname' => 'required|min:2|max:15',
            'gender' => 'required|min:1|max:1',
            'partai' => 'required|min:1|max:2',
            'tingkat' => 'required|min:1|max:1',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'no_urut' => 'required|int|min:1|max:100'
        ],[
            'fname.required'=>'Nama depan tidak boleh kosong!',
            'fname.min'=>'Maaf Nama depan minimal 2 karakter!',
            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
            'lname.required'=>'Nama belakang tidak boleh kosong!',
            'lname.max'=>'Nama maximal 15 karakter!',
            'lname.min'=>' Nama belakang minimal 2 karakter!',
            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
            'partai.required' => 'Partai harus diisi!',
            'partai.max' => 'Partai maximal 1 karakter!',
            'partai.max' => 'Partai minimal 1 karakter!',
            'tingkat.required' => 'Tingkat harus diisi!',
            'tingkat.max' => 'Tingkat maximal 1 karakter!',
            'tingkat.max' => 'Tingkat minimal 1 karakter!',
            'no_urut.required' => 'Nomor urut harus diisi!',
            'no_urut.int' => 'Nomor urut harus bilangan!',
            'no_urut.min' => 'Nomor urut minimal 1 bilangan!',
            'no_urut.max' => 'Nomor urut maksimal 3 bilangan!'
        ]);
        
        if($request->hasFile('foto'))
        {
        	$image = $request->file('foto');
	        $foto = time().'.'.$image->getClientOriginalExtension();
	        $image->move(public_path('img/caleg'), $foto);
        }
        else
        {
        	$foto = "default_avatar.jpg";
        }
        
        if($request->tingkat == 'a')
        {
        	$prov = null;
        	$kab = null;
        	$dapil = null;
        	$kec = null;
        }
        elseif($request->tingkat == 'b')
        {
        	$prov = $request->prov;
        	$kab = null;
        	$dapil = null;
        	$kec = null;
        }
        elseif($request->tingkat == 'c' || $request->tingkat == 'd')
        {
        	$prov = $request->prov;
        	$kab = $request->kab;
        	$kec = null;
        	$dapil = $request->dapil;
        }
        else
        {
        	$kec = $request->kec;
        	$prov = $request->prov;
        	$kab = $request->kab;
        	$dapil = $request->dapil;
        }

        $data = ['id' => $request->id,
        		'fname' => $request->fname,
                'lname' => $request->lname,
                'gender' => $request->gender,
                'partai' => $request->partai,
                'dapil' => $dapil,
            	'tingkat' => $request->tingkat,
            	'foto' => $foto,
            	'prov' => $prov,
            	'kab' => $kab,
            	'kec' => $kec,
                'no_urut' => $request->no_urut
            	];

        $req = new calegModel();
        $req = $req->registerPost($data);
        $req = json_decode(json_encode($req), true);
        if($req[0]['msg'] == "success")
        {
            return redirect()->back()->with('alert-success','Registrasi data caleg sukses!');
        }
        else
        {
            return redirect()->back()->with('alert','Registrasi data caleg gagal!');
        }
    }

    function getAllCaleg()
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
	    	$req = new calegModel();
	    	$dataModel = new dataModel();
    		$req = $req->getAllCaleg();
    		$dapil = $dataModel->getAllDapil();

    		return view('admin.caleg.userlist', compact('req', 'dapil'));
	    }
    }

    function viewCaleg($id_caleg)
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
	    	$data = new calegModel();
	    	$data = $data->getProfile($id_caleg);

	    	$reg = new dataModel();
	    	$partais = $reg->getPartai();
            $provinsi = $reg->getProv();
            if($data->tingkat == 'a')
            {
            	return view('admin.caleg.view')->with(compact('data', 'partais')); 
            }
            elseif($data->tingkat == 'b') 
            {
            	$dapil = $reg->getDapilByProv($data->id_prov, 'a');
            	return view('admin.caleg.view')->with(compact('data', 'partais', 'provinsi', 'dapil'));
            }
            elseif($data->tingkat == 'c' || $data->tingkat == 'd')
            {
            	$dapil = $reg->getDapilByProv($data->id_prov, 'b');
            	$kab = $reg->getKab($data->id_prov);
            	return view('admin.caleg.view')->with(compact('data', 'partais', 'provinsi', 'kab', 'dapil'));
            }
            elseif($data->tingkat == 'e')
            {
            	$dapil = $reg->getDapilByKab($data->id_prov, $data->id_kab, 'c');
            	$kab = $reg->getKab($data->id_prov);
            	$kec = $reg->getKec($data->id_kab);
            	return view('admin.caleg.view')->with(compact('data', 'partais', 'provinsi', 'kab', 'kec', 'dapil'));
            }
	    }
    }

    function deleteCaleg($id_caleg)
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
	    	$data = new calegModel();
	    	$req = $data->deleteCaleg($id_caleg);
        	$req = json_decode(json_encode($req), true);
        	if($req[0]['msg'] == "success")
	    	{
	    		return "Hapus data saksi sukses!";
	    	}
	    	elseif($req[0]['msg'] == "data not found")
	    	{
	    		return "Data caleg ID tersebut tidak ditemukan!";
	    	}
	    	else
	    	{
	    		return "Hapus data saksi gagal!";
	    	}
    	}
	}

	function editCaleg($id_caleg)
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
	    	$data = new calegModel();
	    	$data = $data->getProfile($id_caleg);
	    	$reg = new dataModel();
	    	$partais = $reg->getPartai();
            $provinsi = $reg->getProv();
            if($data->tingkat == 'a')
            {
            	return view('admin.caleg.edit')->with(compact('data', 'partais')); 
            }
            elseif($data->tingkat == 'b') 
            {
            	$dapil = $reg->getDapilByProv($data->id_prov, 'a');
            	return view('admin.caleg.edit')->with(compact('data', 'partais', 'provinsi', 'dapil'));
            }
            elseif($data->tingkat == 'c' || $data->tingkat == 'd')
            {
            	$dapil = $reg->getDapilByProv($data->id_prov, 'b');
            	$kab = $reg->getKab($data->id_prov);
            	return view('admin.caleg.edit')->with(compact('data', 'partais', 'provinsi', 'kab', 'dapil'));
            }
            elseif($data->tingkat == 'e')
            {
            	$dapil = $reg->getDapilByKab($data->id_prov, $data->id_kab, 'c');
            	$kab = $reg->getKab($data->id_prov);
            	$kec = $reg->getKec($data->id_kab);
            	return view('admin.caleg.edit')->with(compact('data', 'partais', 'provinsi', 'kab', 'kec', 'dapil'));
            }            
	    }
    }

    function updateCalegProfile(Request $request)
    {
		$this->validate($request, [
		'id' => 'required|min:1|max:2',
		'id.required' => 'ID caleg harus diisi!',
        'id.max' => 'ID caleg maximal 2 karakter!',
        'id.min' => 'ID caleg minimal 1 karakter!',
        'fname' => 'required|min:2|max:15',
        'lname' => 'required|min:2|max:15',
        'gender' => 'required|min:1|max:1',
        'partai' => 'required|min:1|max:2',
        'tingkat' => 'required|min:1|max:1',
        'dapil' => 'min:1|max:2',
        'fotos' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'no_urut' => 'required|int|min:1|max:100'
        ],[
            'fname.required'=>'Nama depan tidak boleh kosong!',
            'fname.min'=>'Maaf Nama depan minimal 2 karakter!',
            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
            'lname.required'=>'Nama belakang tidak boleh kosong!',
            'lname.max'=>'Nama maximal 15 karakter!',
            'lname.min'=>' Nama belakang minimal 2 karakter!',
            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
            'partai.required' => 'Partai harus diisi!',
            'partai.max' => 'Partai maximal 1 karakter!',
            'partai.max' => 'Partai minimal 1 karakter!',
            'tingkat.required' => 'Tingkat harus diisi!',
            'tingkat.max' => 'Tingkat maximal 1 karakter!',
            'tingkat.max' => 'Tingkat minimal 1 karakter!',
            'no_urut.required' => 'Nomor urut harus diisi!',
            'no_urut.int' => 'Nomor urut harus bilangan!',
            'no_urut.min' => 'Nomor urut minimal 1 bilangan!',
            'no_urut.max' => 'Nomor urut maksimal 3 bilangan!'
        ]);
        if($request->hasFile('fotos'))
        {
        	$image = $request->file('fotos');
	        $foto = time().'.'.$image->getClientOriginalExtension();
	        $image->move(public_path('img/caleg'), $foto);
        }
        else
        {
        	$foto = "default_avatar.jpg";
        }
        
        if($request->tingkat == 'a')
        {
        	$prov = null;
        	$kab = null;
        	$dapil = null;
        	$kec = null;
        }
        elseif($request->tingkat == 'b')
        {
        	$prov = $request->prov;
        	$kab = null;
        	$dapil = null;
        	$kec = null;
        }
        elseif($request->tingkat == 'c' || $request->tingkat == 'd')
        {
        	$prov = $request->prov;
        	$kab = $request->kab;
        	$kec = null;
        	$dapil = $request->dapil;
        }
        else
        {
        	$kec = $request->kec;
        	$prov = $request->prov;
        	$kab = $request->kab;
        	$dapil = $request->dapil;
        }

        $data = ['id' => $request->id,
        		'fname' => $request->fname,
                'lname' => $request->lname,
                'gender' => $request->gender,
                'partai' => $request->partai,
                'dapil' => $dapil,
            	'tingkat' => $request->tingkat,
            	'foto' => $foto,
            	'prov' => $prov,
            	'kab' => $kab,
            	'kec' => $kec,
                'no_urut' => $request->no_urut
            	];

        $req = new calegModel();
        $req = $req->updateProfile($data);
        $req = json_decode(json_encode($req), true);
        if($req[0]['msg'] == "success")
        {
            return redirect()->back()->with('alert-success', 'Update data caleg sukses!');
    	}
    	else
    	{
    		return redirect()->back()->with('alert','Update data caleg gagal!');
    	}
    }
}
