<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\adminModel;

class AdminLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function login()
    {
        return view('admin.login.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function loginPost(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) 
        {
            $data = new adminModel();
            $data = $data->cekLogin($request->username);
            Session::put('username', $data->username);
            Session::put('id', $data->id);
            Session::put('login', true);
            Session::put('role', 'admin');
            Session::put('nama_depan', $data->nama_depan);
            Session::put('nama_belakang', $data->nama_belakang);
            Session::put('hp', $data->hp);
            return redirect()->route('index.admin');
        }
        return redirect()->back()->with('alert','Maaf username dan password Anda salah!');
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    public function username()
    {
        return 'username';
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Session::flush();
        return redirect('admin/login');
    }
}
