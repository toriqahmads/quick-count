<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use App\saksiModel;
use App\dataModel;

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

    function registerSaksiPost(Request $request)
    {
        $this->validate($request, [
        'fname' => 'required|min:4|max:15',
        'lname' => 'required|min:4|max:15',
        'nik' => 'required|min:16|unique:saksi|max:16',
        'telp' => 'required|min:11|max:13',
        'gender' => 'required|min:1|max:1',
        'alamat' => 'required|min:10|max:30',
        'kec' => 'required|min:1',
        'kel' => 'required|min:1',
        'tps' => 'required|min:1',
        'prov' => 'required|min:1',
        'kab' => 'required|min:1',
        'password' => 'required|min:6',
        'confirmation' => 'required|same:password|min:6',
        'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal 6 karakter!',
            'confirmation.required' => 'Konfirmasi password tidak boleh kosong!',
            'confirmation.min' => 'Maaf, password minimal 6 karakter!',
            'confirmation.same' => 'Maaf, password yang Anda masukkan tidak sama!'
        ]);

        if($request->hasFile('foto'))
        {
            $image = $request->file('foto');
            $foto = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('img/saksi'), $foto); 
        }
        else
        {
            $foto = "default_avatar.jpg";
        }

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
            Session::put('dapil_dprri', $data->dapil_dprri);
            Session::put('dapil_dprprov', $data->dapil_dprprov);
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

    function reg()
    {
        $data = new dataModel();
        $prov = $data->getProv();
        return view('saksi.register.register', compact('prov'));
    }
}
