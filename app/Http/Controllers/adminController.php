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
        $data = Session::get('username');
    	return view('admin.home.index', compact('data'));
    }
}
