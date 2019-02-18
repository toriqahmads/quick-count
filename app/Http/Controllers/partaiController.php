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

class partaiController extends Controller
{
    function registerPartai()
    {
	    return view('admin.partai.register');
    }

	function registerPostPartai(Request $request)
    {
        $this->validate($request, [
            'partai' => 'required|min:3|max:25',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'no_urut' => 'required|int|min:1'
        ],[ 'partai.required' => 'Partai harus diisi!',
            'partai.max' => 'Partai maximal 25 karakter!',
            'partai.min' => 'Partai minimal 3 karakter!',
            'no_urut.required' => 'Nomor urut harus diisi!',
            'no_urut.int' => 'Nomor urut harus bilangan!',
            'no_urut.min' => 'Nomor urut minimal 1 bilangan!',
        ]);
        if($request->hasFile('foto'))
        {
        	$image = $request->file('foto');
	        $foto = time().'.'.$image->getClientOriginalExtension();
	        $image->move(public_path('img/partai'), $foto);
        }
        else
        {
        	$foto = "default_avatar.jpg";
        }

        $data = ['partai' => $request->partai,
            	'foto' => $foto,
            	'no_urut' => $request->no_urut
            	];

        $req = new partaiModel();
        $req = $req->registerPost($data);
        if($req)
        {
            return redirect()->back()->with('alert-success','Registrasi data partai sukses!');
        }
        else
        {
            return redirect()->back()->with('alert','Registrasi data partai gagal!');
        }
    }

    function getAllPartai()
    {
    	$req = new partaiModel();
		$req = $req->getAllPartai();

		return view('admin.partai.userlist', compact('req'));
    }

    function editPartai($id_partai)
    {
    	$data = new partaiModel();
    	$data = $data->getProfile($id_partai);
    	return view('admin.partai.edit', compact('data'));
    }

    function updatePartai(Request $request)
    {
		$this->validate($request, [
        'id' => 'required|min:1',
        'partai' => 'required|min:3|max:25',
        'foto' => 'required'
        ],[ 'id.required' => 'ID Partai harus diisi!',
            'id.min' => 'ID Partai minimal 1 karakter!',
            'partai.required' => 'Partai harus diisi!',
            'partai.max' => 'Partai maximal 25 karakter!',
            'partai.min' => 'Partai minimal 3 karakter!',
            'no_urut.required' => 'Nomor urut harus diisi!',
            'no_urut.int' => 'Nomor urut harus bilangan!',
            'no_urut.min' => 'Nomor urut minimal 1 bilangan!',
        ]);

        if($request->hasFile('fotos'))
        {
        	$image = $request->file('fotos');
	        $foto = time().'.'.$image->getClientOriginalExtension();
	        $image->move(public_path('img/partai'), $foto);
        }
        else
        {
        	$foto = "default_avatar.jpg";
        }

        $data = ['id' => $request->id,
        		'partai' => $request->partai,
            	'foto' => $foto,
            	'no_urut' => $request->no_urut
            	];        

        $req = new partaiModel();
        $req = $req->updateProfile($data);
        if($req)
        {
            return redirect()->back()->with('alert-success','Update data Partai sukses!');
        }
        else
        {
            return redirect()->back()->with('alert', 'Update data Partai gagal!');
        }
    }

    function viewPartai($id_partai)
    {
    	$data = new partaiModel();
    	$data = $data->getProfile($id_partai);
    	return view('admin.partai.view', compact('data'));
    }

    function deletePartai($id_partai)
    {
    	$data = new partaiModel();
    	$req = $data->deletePartai($id_partai);
    	return $req;
	}
}
