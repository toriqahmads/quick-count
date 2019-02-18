<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\saksiModel;

class SaksiLoginController extends Controller
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
    protected $redirectTo = '/saksi';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:saksi')->except('logout');
    }

    public function login()
    {
        return view('saksi.login.login');
    }

    protected function guard()
    {
        return Auth::guard('saksi');
    }

    public function loginPost(Request $request)
    {
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('saksi')->attempt(['username' => $request->username, 'password' => $request->password])) 
        {
            $data = new saksiModel();
            $data = $data->cekLogin($request->username);
            Session::put('username', $data->username);
            Session::put('id', $data->id);
            Session::put('id_prov', $data->id_prov);
            Session::put('id_kab', $data->id_kab);
            Session::put('id_kec', $data->id_kec);
            Session::put('id_kel', $data->id_kel);
            Session::put('id_tps', $data->id_tps);
            Session::put('dapil_kec', $data->dapil_kec);
            Session::put('dapil_kab', $data->dapil_kab);
            Session::put('dapil_prov', $data->dapil_prov);
            Session::put('login', true);
            Session::put('role', 'saksi');
            return redirect()->route('index.saksi');
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
        Auth::guard('saksi')->logout();
        Session::flush();
        return redirect('saksi/login');
    }
}
