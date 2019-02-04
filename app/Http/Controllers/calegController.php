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
	    	$kec = $data->getKec(1);
	    	$partai = $data->getPartai();
	    	return view('admin.caleg.register', compact('kec', 'partai'));
	    }
    }

    function registerPostCaleg(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'gender' => 'required|min:1|max:1',
            'partai' => 'required|min:1|max:2',
            'tingkat' => 'required|min:1|max:1',
            'dapil' => 'required|min:1',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],[
            'fname.required'=>'Nama depan tidak boleh kosong!',
            'fname.min'=>'Maaf Nama depan minimal 4 karakter!',
            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
            'lname.required'=>'Nama belakang tidak boleh kosong!',
            'lname.max'=>'Nama maximal 15 karakter!',
            'lname.min'=>' Nama belakang minimal 4 karakter!',
            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
            'partai.required' => 'Partai harus diisi!',
            'partai.max' => 'Partai maximal 1 karakter!',
            'partai.max' => 'Partai minimal 1 karakter!',
            'tingkat.required' => 'Tingkat harus diisi!',
            'tingkat.max' => 'Tingkat maximal 1 karakter!',
            'tingkat.max' => 'Tingkat minimal 1 karakter!',
            'dapil.required' => 'Dapil tidak boleh kosong',
        ]);
        $image = $request->file('foto');
        $foto = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('img/caleg'), $foto);

        $data = ['fname' => $request->fname,
                'lname' => $request->lname,
                'gender' => $request->gender,
                'partai' => $request->partai,
                'dapil' => $request->dapil,
            	'tingkat' => $request->tingkat,
            	'foto' => $foto
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
    		$req = $req->getAllCaleg();

    		return view('admin.caleg.userlist', compact('req'));
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
	    	$kecamatan = new dataModel();
	    	return view('admin.caleg.view', compact('data'));
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
	    	$kecamatan = new dataModel();
	    	$partais = $kecamatan->getPartai();
	    	return view('admin.caleg.edit', compact('data', 'partais'));
	    }
    }

    function updateCalegProfile(Request $request)
    {
    	$data = [];
    	if($request->hasFile('fotos'))
    	{
    		$this->validate($request, [
    		'id' => 'required|min:1|max:2',
    		'id.required' => 'ID caleg harus diisi!',
	        'id.max' => 'ID caleg maximal 2 karakter!',
	        'id.min' => 'ID caleg minimal 1 karakter!',
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'gender' => 'required|min:1|max:1',
            'partai' => 'required|min:1|max:2',
            'tingkat' => 'required|min:1|max:1',
            'dapil' => 'required|min:1|max:2',
            'fotos' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
	        ],[
	            'fname.required'=>'Nama depan tidak boleh kosong!',
	            'fname.min'=>'Maaf Nama depan minimal 4 karakter!',
	            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
	            'lname.required'=>'Nama belakang tidak boleh kosong!',
	            'lname.max'=>'Nama maximal 15 karakter!',
	            'lname.min'=>' Nama belakang minimal 4 karakter!',
	            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
	            'partai.required' => 'Partai harus diisi!',
	            'partai.max' => 'Partai maximal 1 karakter!',
	            'partai.max' => 'Partai minimal 1 karakter!',
	            'tingkat.required' => 'Tingkat harus diisi!',
	            'tingkat.max' => 'Tingkat maximal 1 karakter!',
	            'tingkat.max' => 'Tingkat minimal 1 karakter!',
	            'dapil.required' => 'Dapil tidak boleh kosong',
	        ]);
	        $image = $request->file('fotos');
	        $foto = time().'.'.$image->getClientOriginalExtension();
	        $image->move(public_path('img/caleg'), $foto);

	        $data = ['id' => $request->id,
	        		'fname' => $request->fname,
	                'lname' => $request->lname,
	                'gender' => $request->gender,
	                'partai' => $request->partai,
	                'dapil' => $request->dapil,
	            	'tingkat' => $request->tingkat,
	            	'foto' => $foto
	            	];
    	}
    	else
    	{
    		$this->validate($request, [
        	'id' => 'required|min:1|max:2',
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'gender' => 'required|min:1|max:1',
            'partai' => 'required|min:1|max:1',
            'tingkat' => 'required|min:1|max:1',
            'dapil' => 'required|min:1|max:2',
            'foto' => 'required'
	        ],[
	        	'id.required' => 'ID caleg harus diisi!',
	            'id.max' => 'ID caleg maximal 2 karakter!',
	            'id.min' => 'ID caleg minimal 1 karakter!',
	            'fname.required'=>'Nama depan tidak boleh kosong!',
	            'fname.min'=>'Maaf Nama depan minimal 4 karakter!',
	            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
	            'lname.required'=>'Nama belakang tidak boleh kosong!',
	            'lname.max'=>'Nama maximal 15 karakter!',
	            'lname.min'=>' Nama belakang minimal 4 karakter!',
	            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
	            'partai.required' => 'Partai harus diisi!',
	            'partai.max' => 'Partai maximal 1 karakter!',
	            'partai.min' => 'Partai minimal 1 karakter!',
	            'tingkat.required' => 'Tingkat harus diisi!',
	            'tingkat.max' => 'Tingkat maximal 1 karakter!',
	            'tingkat.min' => 'Tingkat minimal 1 karakter!',
	            'dapil.required' => 'Dapil tidak boleh kosong',
	        ]);

	        $data = ['id' => $request->id,
	        		'fname' => $request->fname,
	                'lname' => $request->lname,
	                'gender' => $request->gender,
	                'partai' => $request->partai,
	                'dapil' => $request->dapil,
	            	'tingkat' => $request->tingkat,
	            	'foto' => $request->foto];
    	}

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
