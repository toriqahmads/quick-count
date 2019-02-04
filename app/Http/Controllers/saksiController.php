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

class saksiController extends Controller
{
    function registerSaksi()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('admin/login')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('alert', 'Forbidden');
	    }
	    else
	    {
	    	$data = new dataModel();
	    	$data = $data->getKec(1);
	    	return view('admin.saksi.register', compact('data'));
	    }
    }

    function registerSaksiPost(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'nik' => 'required|min:16|unique:saksi|max:16',
            'telp' => 'required|min:11|max:13',
            'gender' => 'required|min:1|max:1',
            'alamat' => 'required|min:10|max:30',
            'kec' => 'required|min:1|max:3',
            'kel' => 'required|min:1|max:3',
            'tps' => 'required|min:1|max:3',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:3',
            'dapil' => 'required|min:1|max:2',
            'password' => 'required|min:6',
            'confirmation' => 'required|same:password|min:6',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],[
            'fname.required'=>'Nama depan tidak boleh kosong!',
            'fname.min'=>'Maaf Nama depan minimal 4 karakter!',
            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
            'lname.required'=>'Nama belakang tidak boleh kosong!',
            'lname.max'=>'Nama maximal 15 karakter!',
            'lname.min'=>' Nama belakang minimal 4 karakter!',
            'nik.required' => 'NIK tidak boleh kosong!',
            'nik.min' => 'NIK minimal 16 karakter!',
            'nik.max' => 'NIK maximal 16 karakter!',
            'nik.unique' => 'NIK sudah terdaftar.',
            'telp.required' => 'Telephone boleh kosong!',
            'telp.min' => 'Telephone minimal 11 karakter!',
            'telp.max' => 'Telephone maximal 13 karakter!',
            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
            'alamat.required' => 'Alamat tidak boleh kosong!',
            'alamat.min' => 'Alamat minimal 10 karakter!',
            'alamat.max' => 'Alamat minimal 30 karakter!',
            'kec.required' => 'Kecapatan tidak boleh kosong!',
            'kel.required' => 'Kelurahan tidak boleh kosong!',
            'tps.required' => 'TPS tidak boleh kosong!',
            'prov.required' => 'Provinsi tidak boleh kosong',
            'kab.required' => 'Kabupaten tidak boleh kosong',
            'dapil.required' => 'Dapil tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal 6 karakter!',
            'confirmation.required' => 'Konfirmasi password tidak boleh kosong!',
            'confirmation.min' => 'Maaf, password minimal 6 karakter!',
            'confirmation.same' => 'Maaf, password yang Anda masukkan tidak sama!'
        ]);

        $image = $request->file('foto');
        $foto = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('img/saksi'), $foto);

        $data = ['fname' => $request->fname,
                'lname' => $request->lname,
                'nik' => $request->nik,
                'telp' => $request->telp,
                'gender' => $request->gender,
                'alamat' => $request->alamat,
                'kec' => $request->kec,
                'kel' => $request->kel,
                'tps' => $request->tps,
                'prov' => $request->prov,
                'kab' => $request->kab,
                'dapil' => $request->dapil,
                'password' => bcrypt($request->password),
            	'foto' => $foto];

        $req = new saksiModel();
        $req = $req->registerPost($data);
        $req = json_decode(json_encode($req), true);
        if($req[0]['msg'] == "success")
        {
            return redirect()->back()->with('alert-success','Registrasi data saksi sukses!');
        }
        else
        {
            return redirect()->back()->with('alert','Registrasi data saksi gagal!');
        }
    }

    function updateSaksiProfile(Request $request)
    {
    	if($request->hasFile('fotos'))
    	{
    		$this->validate($request, [
    		'id' => 'required|min:1|max:2',
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'nik' => 'required|min:16|unique:saksi,nik,'.$request->id.'|max:16',
            'telp' => 'required|min:11|max:13',
            'gender' => 'required|min:1|max:1',
            'alamat' => 'required|min:10|max:30',
            'kec' => 'required|min:1|max:3',
            'kel' => 'required|min:1|max:3',
            'tps' => 'required|min:1|max:5',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:3',
            'dapil' => 'required|min:1|max:2',
            'fotos' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
	        ],[
	        	'id.required' => 'ID saksi harus diisi!',
            	'id.max' => 'ID saksi maximal 2 karakter!',
            	'id.min' => 'ID saksi minimal 1 karakter!',
	            'fname.required'=>'Nama depan tidak boleh kosong!',
	            'fname.min'=>'Maaf Nama depan minimal 4 karakter!',
	            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
	            'lname.required'=>'Nama belakang tidak boleh kosong!',
	            'lname.max'=>'Nama maximal 15 karakter!',
	            'lname.min'=>' Nama belakang minimal 4 karakter!',
	            'nik.required' => 'NIK tidak boleh kosong!',
	            'nik.min' => 'NIK minimal 16 karakter!',
	            'nik.max' => 'NIK maximal 16 karakter!',
	            'nik.unique' => 'NIK sudah terdaftar.',
	            'telp.required' => 'Telephone boleh kosong!',
	            'telp.min' => 'Telephone minimal 11 karakter!',
	            'telp.max' => 'Telephone maximal 13 karakter!',
	            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
	            'alamat.required' => 'Alamat tidak boleh kosong!',
	            'alamat.min' => 'Alamat minimal 10 karakter!',
	            'alamat.max' => 'Alamat minimal 30 karakter!',
	            'kec.required' => 'Kecapatan tidak boleh kosong!',
	            'kel.required' => 'Kelurahan tidak boleh kosong!',
	            'tps.required' => 'TPS tidak boleh kosong!',
	            'prov.required' => 'Provinsi tidak boleh kosong',
	            'kab.required' => 'Kabupaten tidak boleh kosong',
	            'dapil.required' => 'Dapil tidak boleh kosong',
	        ]);

	        $image = $request->file('fotos');
	        $foto = time().'.'.$image->getClientOriginalExtension();
	        $image->move(public_path('img/saksi'), $foto);

	        $data = ['id' => $request->id,
	        		'fname' => $request->fname,
	                'lname' => $request->lname,
	                'nik' => $request->nik,
	                'telp' => $request->telp,
	                'gender' => $request->gender,
	                'alamat' => $request->alamat,
	                'kec' => $request->kec,
	                'kel' => $request->kel,
	                'tps' => $request->tps,
	                'prov' => $request->prov,
	                'kab' => $request->kab,
	                'dapil' => $request->dapil,
	                'password' => bcrypt($request->password),
	            	'foto' => $foto];
    	}
    	else
    	{
    		$this->validate($request, [
    		'id' => 'required|min:1|max:2',
            'fname' => 'required|min:4|max:15',
            'lname' => 'required|min:4|max:15',
            'nik' => 'required|min:16|unique:saksi,nik,'.$request->id.'|max:16',
            'telp' => 'required|min:11|max:13',
            'gender' => 'required|min:1|max:1',
            'alamat' => 'required|min:10|max:30',
            'kec' => 'required|min:1|max:3',
            'kel' => 'required|min:1|max:3',
            'tps' => 'required|min:1|max:5',
            'prov' => 'required|min:1|max:2',
            'kab' => 'required|min:1|max:3',
            'dapil' => 'required|min:1|max:2',
            'foto' => 'required'
	        ],[
	        	'id.required' => 'ID saksi harus diisi!',
	            'id.max' => 'ID saksi maximal 2 karakter!',
	            'id.min' => 'ID saksi minimal 1 karakter!',
	            'fname.required'=>'Nama depan tidak boleh kosong!',
	            'fname.min'=>'Maaf Nama depan minimal 4 karakter!',
	            'fname.max'=>'Maaf Nama depan maximal 15 karakter!',
	            'lname.required'=>'Nama belakang tidak boleh kosong!',
	            'lname.max'=>'Nama maximal 15 karakter!',
	            'lname.min'=>' Nama belakang minimal 4 karakter!',
	            'nik.required' => 'NIK tidak boleh kosong!',
	            'nik.min' => 'NIK minimal 16 karakter!',
	            'nik.max' => 'NIK maximal 16 karakter!',
	            'nik.unique' => 'NIK sudah terdaftar.',
	            'telp.required' => 'Telephone boleh kosong!',
	            'telp.min' => 'Telephone minimal 11 karakter!',
	            'telp.max' => 'Telephone maximal 13 karakter!',
	            'gender.required' => 'Jenis Kelamin tidak boleh kosong!',
	            'alamat.required' => 'Alamat tidak boleh kosong!',
	            'alamat.min' => 'Alamat minimal 10 karakter!',
	            'alamat.max' => 'Alamat minimal 30 karakter!',
	            'kec.required' => 'Kecapatan tidak boleh kosong!',
	            'kel.required' => 'Kelurahan tidak boleh kosong!',
	            'tps.required' => 'TPS tidak boleh kosong!',
	            'prov.required' => 'Provinsi tidak boleh kosong',
	            'kab.required' => 'Kabupaten tidak boleh kosong',
	            'dapil.required' => 'Dapil tidak boleh kosong',
	        ]);

	        $data = ['id' => $request->id,
        		'fname' => $request->fname,
    			'lname' => $request->lname,
    			'nik' => $request->nik,
    			'telp' => $request->telp,
    			'gender' => $request->gender,
    			'alamat' => $request->alamat,
    			'kec' => $request->kec,
    			'kel' => $request->kel,
    			'tps' => $request->tps,
    			'prov' => $request->prov,
    			'kab' => $request->kab,
    			'dapil' => $request->dapil,
    			'foto' => $request->foto
    			];
    	}

    	$req = new saksiModel();
    	$req = $req->updateProfile($data);
    	$req = json_decode(json_encode($req), true);
    	if($req[0]['msg'] == "success")
    	{
    		return redirect()->back()->with('alert-success','Update data saksi sukses!');
    	}
    	else
    	{
    		return redirect()->back()->with('alert','Update data saksi gagal!');
    	}
    }

    function getAllSaksi()
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
	    	$req = new saksiModel();
    		$req = $req->getAllSaksi();

    		return view('admin.saksi.userlist', compact('req'));
	    }
    }

    function editSaksi($nik, $id_saksi)
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
	    	$data = new saksiModel();
	    	$data = $data->getProfile($nik, $id_saksi);
	    	$kecamatan = new dataModel();
	    	$kecs = $kecamatan->getKec(1);
	    	$kels = $kecamatan->getKel($data->id_kec);
	    	$tps = $kecamatan->getTps($data->id_kel);
	    	return view('admin.saksi.edit', compact('data', 'kecs', 'kels', 'tps'));
	    }
    }

    function viewSaksi($nik, $id_saksi)
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
	    	$data = new saksiModel();
	    	$data = $data->getProfile($nik, $id_saksi);
	    	$kecamatan = new dataModel();
	    	return view('admin.saksi.view', compact('data'));
	    }
    }

    function deleteSaksi($nik, $id_saksi)
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
	    	$data = new saksiModel();
	    	$req = $data->deleteSaksi($nik, $id_saksi);
        	$req = json_decode(json_encode($req), true);
        	if($req[0]['msg'] == "success")
	    	{
	    		return "Hapus data saksi sukses!";
	    	}
	    	elseif($req[0]['msg'] == "data not found")
	    	{
	    		return "Data saksi dengan NIK dan ID tersebut tidak ditemukan!";
	    	}
	    	else
	    	{
	    		return "Hapus data saksi gagal!";
	    	}
    	}
	}
}
