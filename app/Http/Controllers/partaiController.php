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
	    	return view('admin.partai.register');
	    }
    }

	function registerPostPartai(Request $request)
    {
        $this->validate($request, [
            'partai' => 'required|min:5|max:25',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'no_urut' => 'required|int|min:1|max:3'
        ],[ 'partai.required' => 'Partai harus diisi!',
            'partai.max' => 'Partai maximal 25 karakter!',
            'partai.min' => 'Partai minimal 5 karakter!',
            'no_urut.required' => 'Nomor urut harus diisi!',
            'no_urut.int' => 'Nomor urut harus bilangan!',
            'no_urut.min' => 'Nomor urut minimal 1 bilangan!',
            'no_urut.max' => 'Nomor urut maksimal 3 bilangan!'
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
	    	$req = new partaiModel();
    		$req = $req->getAllPartai();

    		return view('admin.partai.userlist', compact('req'));
	    }
    }

    function editPartai($id_partai)
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
	    	$data = new partaiModel();
	    	$data = $data->getProfile($id_partai);
	    	return view('admin.partai.edit', compact('data'));
	    }
    }

    function updatePartai(Request $request)
    {
    	$data = [];
    	if($request->hasFile('fotos'))
    	{
    		$this->validate($request, [
            'partai' => 'required|min:5|max:25',
            'fotos' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'no_urut' => 'required|int|min:1|max:3'
	        ],[ 'partai.required' => 'Partai harus diisi!',
	            'partai.max' => 'Partai maximal 25 karakter!',
	            'partai.min' => 'Partai minimal 5 karakter!',
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
	            	'foto' => $foto
	            	];
    	}
    	else
    	{
    		$this->validate($request, [
            'partai' => 'required|min:5|max:25',
            'foto' => 'required'
	        ],[ 'partai.required' => 'Partai harus diisi!',
	            'partai.max' => 'Partai maximal 25 karakter!',
	            'partai.min' => 'Partai minimal 5 karakter!',
	            'no_urut.required' => 'Nomor urut harus diisi!',
	            'no_urut.int' => 'Nomor urut harus bilangan!',
	            'no_urut.min' => 'Nomor urut minimal 1 bilangan!',
	            'no_urut.max' => 'Nomor urut maksimal 3 bilangan!'
	        ]);
	        $data = ['id' => $request->id,
	        		'partai' => $request->partai,
	            	'foto' => $request->foto,
	            	'no_urut' => $request->no_urut
	            	];
    	}
        

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
	    	$data = new partaiModel();
	    	$data = $data->getProfile($id_partai);
	    	return view('admin.partai.view', compact('data'));
	    }
    }

    function deletePartai($id_partai)
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
	    	$data = new partaiModel();
	    	$req = $data->deletePartai($id_partai);
	    	#$req->delete();
        	return $req;
    	}
	}
}
