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

class suaraController extends Controller
{
    function registerSuara()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	if(Session::get('role') == 'admin')
	    	{
	    		return view('admin.suara.register');
	    	}
	    	else
	    	{
	    		return view('saksi.suara.register');
	    	}
	    }
    }

    function registerDprKab()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new dataModel();
	    	$prov = $data->getProv();
	    	$partai = $data->getPartai();
	    	if(Session::get('role') == 'admin')
	    	{
	    		return view('admin.suara.dprkab', compact('prov', 'partai'));
	    	}
	    	else
	    	{
	    		return view('saksi.suara.dprkab', compact('prov', 'partai'));
	    	}
	    }
    }

    function registerDprProv()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new dataModel();
	    	$prov = $data->getProv();
	    	$partai = $data->getPartai();
	    	if(Session::get('role') == 'admin')
	    	{
	    		return view('admin.suara.dprprov', compact('prov', 'partai'));
	    	}
	    	else
	    	{
	    		return view('saksi.suara.dprprov', compact('prov', 'partai'));
	    	}
	    }
    }

    function registerDprRi()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new dataModel();
	    	$prov = $data->getProv();
	    	$partai = $data->getPartai();
	    	if(Session::get('role') == 'admin')
	    	{
	    		return view('admin.suara.dprri', compact('prov', 'partai'));
	    	}
	    	else
	    	{
	    		return view('saksi.suara.dprri', compact('prov', 'partai'));
	    	}
	    }
    }

    function registerDpd()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new dataModel();
	    	$prov = $data->getProv();
	    	$partai = $data->getPartai();
	    	if(Session::get('role') == 'admin')
	    	{
	    		return view('admin.suara.dpd', compact('prov', 'partai'));
	    	}
	    	else
	    	{
	    		return view('saksi.suara.dpd', compact('prov', 'partai'));
	    	}
	    }
    }

    function registerPres()
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new dataModel();
	    	$prov = $data->getProv();
	    	$partai = $data->getPartai();
	    	if(Session::get('role') == 'admin')
	    	{
	    		return view('admin.suara.pres', compact('prov', 'partai'));
	    	}
	    	else
	    	{
	    		return view('saksi.suara.pres', compact('prov', 'partai'));
	    	}
	    }
    }

    function registerForm(Request $request)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$jenis = $request->jenis;
	    	$data = new dataModel();
	    	$partai = $data->getPartai();
	    	$form = '';
	  		if($jenis == 'a')
	  		{
	  			$form = 'presiden';
	  		}
	  		elseif($jenis == 'b')
	  		{
	  			$form = 'dpd';
	  		}
	  		elseif($jenis == 'c')
	  		{
	  			$form = 'dprri';
	  		}
	  		elseif($jenis == 'd')
	  		{
	  			$form = 'dprprov';
	  		}
	  		elseif($jenis == 'e')
	  		{
	  			$form = 'dprkab';
	  		}

  			return redirect()->route('register.'.$form);
	    }
    }

	function registerPostSuara(Request $request)
    {
        $validate = $this->validate($request, [
            'suarapartai' => 'required|array',
            'suarapartai.*' => 'integer',
            'suara' => 'required|array',
            'suara.*.*' => 'integer',
            'tingkat' => 'required'
        ],[ 'suarapartai.required' => 'Suara partai harus diisi!',
            'suara.' => 'Suara caleg harus diisi!',
            'tingkat.required' => 'Tingkat harus diisi!',
        ]);

        $input = $request->all();
        $proses = new suaraModel();

        $data = array();
        $data['tps'] = $input['tps'];
        $data['saksi'] = $input['saksi'];
        $data['tingkat'] = $input['tingkat'];
        $req = array();

        foreach ($input['suarapartai'] as $id_partai => $value) 
        {
        	$data['suara'] = $value;
        	$data['caleg'] = null;
        	$data['partai'] = $id_partai;
        	$data['jenis'] = 'p';

        	$proses->registerPost($data);
        	$req['suara_partai'] = "success";
        	unset($data);
        }

        foreach ($input['suara'] as $id_partai => $suara) 
        {
        	foreach ($suara as $id_caleg => $value) 
        	{
        		$data = array();
		        $data['tps'] = $input['tps'];
		        $data['saksi'] = $input['saksi'];
		        $data['tingkat'] = $input['tingkat'];
        		$data['suara'] = $value;
	        	$data['caleg'] = $id_caleg;
	        	$data['partai'] = $id_partai;
	        	$data['jenis'] = 'c';

	        	$proses->registerPost($data);

	        	unset($data);
        	}

        	$req['suara_caleg'] = "success";
        }

        if($req['suara_partai'] == "success" && $req['suara_caleg'] == "success")
        {
            return $req;//'Sukses kirim suara!';
        }
        else
        {
            return 'Gagal kirim suara!';
        }
    }

    function getAllSuaraPartai($id_dapil, $id_partai, $id_tps)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$req = new suaraModel();
    		$req = $req->getAllSuaraPartai($id_dapil, $id_partai, $id_tps);

    		return $req;
	    }
    }

    function getAllSuaraPartaiBySaksi($id_dapil, $id_partai, $id_tps, $id_saksi)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$req = new suaraModel();
    		$req = $req->getAllSuaraPartaiBySaksi($id_dapil, $id_partai, $id_tps, $id_saksi);

    		return $req;
	    }
    }

    function getAllSuaraPartaiByDapil($id_dapil, $id_partai)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$req = new suaraModel();
    		$req = $req->getAllSuaraPartaiByDapil($id_dapil, $id_partai);

    		return $req;
	    }
    }

    function getAllSuaraCaleg($id_dapil, $id_partai, $id_tps)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$req = new suaraModel();
    		$req = $req->getAllSuaraCaleg($id_dapil, $id_partai, $id_tps);

    		return $req;
	    }
    }

    function getAllSuaraCalegBySaksi($id_dapil, $id_partai, $id_tps, $id_saksi)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$req = new suaraModel();
    		$req = $req->getAllSuaraCalegBySaksi($id_dapil, $id_partai, $id_tps, $id_saksi);

    		return $req;
	    }
    }

    function getAllSuaraCalegByDapil($id_dapil, $id_partai)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$req = new suaraModel();
    		$req = $req->getAllSuaraCalegByDapil($id_dapil, $id_partai);

    		return $req;
	    }
    }

    function editSuara($id_partai)
    {
	    if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new partaiModel();
	    	$data = $data->getProfile($id_partai);
	    	return view('admin.suara.edit', compact('data'));
	    }
    }

    function updateSuara(Request $request)
    {
    	$validate = $this->validate($request, [
            'suarapartai' => 'required|array',
            'suarapartai.*.*' => 'integer',
            'suara' => 'required|array',
            'suara.*.*.*' => 'integer',
            'tingkat' => 'required'
        ],[ 'suarapartai.required' => 'Suara partai harus diisi!',
            'suara.' => 'Suara caleg harus diisi!',
            'tingkat.required' => 'Tingkat harus diisi!',
        ]);

        $input = $request->all();
        $proses = new suaraModel();

        $data = array();
        $data['tps'] = $input['tps'];
        $data['saksi'] = $input['saksi'];
        $data['tingkat'] = $input['tingkat'];
        $req = array();

        foreach ($input['suarapartai'] as $id_partai => $value) 
        {
        	foreach ($value as $id => $values) 
        	{
        		$data['id'] = $id;
        		$data['suara'] = $values;
	        	$data['caleg'] = null;
	        	$data['partai'] = $id_partai;
	        	$data['jenis'] = 'p';

	        	$proses->updateSuara($data);
	        	$req['suara_partai'] = "success";
	        	unset($data);
        	}
        }

        foreach ($input['suara'] as $id_partai => $suara) 
        {
        	foreach ($suara as $id_caleg => $value) 
        	{
        		foreach ($value as $id => $values) 
        		{
        			$data = array();
        			$data['id'] = $id;
			        $data['tps'] = $input['tps'];
			        $data['saksi'] = $input['saksi'];
	        		$data['suara'] = $values;
		        	$data['caleg'] = $id_caleg;
		        	$data['partai'] = $id_partai;
		        	$data['jenis'] = 'c';

		        	$proses->updateSuara($data);

		        	unset($data);
        		}
        	}

        	$req['suara_caleg'] = "success";
        }

        if($req['suara_partai'] == "success" && $req['suara_caleg'] == "success")
        {
            return $req;//'Sukses kirim suara!';
        }
        else
        {
            return 'Gagal kirim suara!';
        }
    }

    function viewSuara()
    {
	    if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$data = new dataModel();
	    	$dapil = $data->getDapil();
	    	$partai = $data->getPartai();
	    	$kec = $data->getKec(1);

	    	if(Session::get('role') == 'admin')
	    	{
	    		return view('admin.suara.view', compact('dapil', 'partai', 'kec'));
	    	}
	    	else
	    	{
	    		return view('saksi.suara.view', compact('dapil', 'partai', 'kec'));
	    	}
	    }
    }

    function deleteSuara(Request $request)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('alert', 'Maaf Anda harus login terlebih dahulu!');
	    }
	    elseif(Session::get('role') != 'admin' && Session::get('role') != 'saksi')
	    {
	    	return redirect('/')->with('alert', 'Forbidden!');
	    }
	    else
	    {
	    	$validate = $this->validate($request, [
            'suarapartai' => 'required|array',
            'suarapartai.*.*' => 'integer',
            'suara' => 'required|array',
            'suara.*.*.*' => 'integer'
	        ],[ 'suarapartai.required' => 'Suara partai harus diisi!',
	            'suara.' => 'Suara caleg harus diisi!',
	        ]);

	        $input = $request->all();
	        $proses = new suaraModel();

	        $data = array();
	        $req = array();

	        foreach ($input['suarapartai'] as $id_partai => $value) 
	        {
	        	foreach ($value as $id => $values) 
	        	{
	        		$data['id'] = $id;

		        	$proses->deleteSuara($data);
		        	$req['suara_partai'] = "success";
		        	unset($data);
	        	}
	        }

	        foreach ($input['suara'] as $id_partai => $suara) 
	        {
	        	foreach ($suara as $id_caleg => $value) 
	        	{
	        		foreach ($value as $id => $values) 
	        		{
	        			$data = array();
	        			$data['id'] = $id;

			        	$proses->deleteSuara($data);

			        	unset($data);
	        		}
	        	}

	        	$req['suara_caleg'] = "success";
	        }

	        if($req['suara_partai'] == "success" && $req['suara_caleg'] == "success")
	        {
	            return $req;//'Sukses kirim suara!';
	        }
	        else
	        {
	            return 'Gagal kirim suara!';
	        }
    	}
	}

	function getAllSuaraPartaiForChartByDapil($id_dapil)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new suaraModel();
    		$req = $req->getAllSuaraPartaiForChartByDapil($id_dapil);

    		return $req;
	    }
    }

    function getAllSuaraPartaiForChartByTps($id_dapil, $id_tps)
    {
    	if(!Session::get('login'))
	    {
	    	return redirect('/')->with('Anda harus login terlebih dahulu');
	    }
	    elseif(Session::get('role') != 'admin')
	    {
	    	return redirect('admin/login')->with('Forbidden');
	    }
	    else
	    {
	    	$req = new suaraModel();
    		$req = $req->getAllSuaraPartaiForChartByTps($id_dapil, $id_tps);

    		return $req;
	    }
    }
}
