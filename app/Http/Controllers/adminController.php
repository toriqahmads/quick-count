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

class adminController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }

    function index()
    {
    	return view('admin.home.index');
    }

    function registerAdminPost(Request $request)
    {
        $this->validate($request, [
        'fname' => 'required|min:4|max:15',
        'lname' => 'required|min:4|max:15',
        'username' => 'required|unique:admin',
        'telp' => 'required|min:11|max:13',
        'password' => 'required|min:6',
        'confirmation' => 'required|same:password|min:6',
        'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ],[
            'fname.required'=>'Nama depan tidak boleh kosong!',
            'fname.min'=>'Maaf Nama depan minimal 3 karakter!',
            'fname.max'=>'Maaf Nama depan maximal 30 karakter!',
            'lname.required'=>'Nama belakang tidak boleh kosong!',
            'lname.max'=>'Nama maximal 30 karakter!',
            'lname.min'=>' Nama belakang minimal 3 karakter!',
            'username.required' => 'Username tidak boleh kosong!',
            'username.unique' => 'Username sudah terdaftar.',
            'telp.required' => 'Telephone boleh kosong!',
            'telp.min' => 'Telephone minimal 11 karakter!',
            'telp.max' => 'Telephone maximal 13 karakter!',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal 6 karakter!',
            'confirmation.required' => 'Konfirmasi password tidak boleh kosong!',
            'confirmation.min' => 'Maaf, password minimal 6 karakter!',
            'confirmation.same' => 'Maaf, password yang Anda masukkan tidak sama!'
        ]);

        $data = ['fname' => $request->fname,
                'lname' => $request->lname,
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'telp' => $request->telp];

        $req = new adminModel();
        $req = $req->registerPost($data);
        $req = json_decode(json_encode($req), true);
        if($req[0]['msg'] == "success")
        {
            return redirect()->back()->with('alert-success','Registrasi admin sukses!');
        }
        else
        {
            return redirect()->back()->with('alert','Registrasi admin gagal!');
        }
    }

    function registerAdmin()
    {
	    return view('admin.register.register');
    }
}
