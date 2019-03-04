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
use App\kelModel;
use App\partaiModel;
use App\suaraDesaModel;

class suaraDesaController extends Controller
{
    function registerSuara($tingkat)
    {
        $data = new dataModel();
        $prov = $data->getProv();
        $partai = $data->getPartai();
        $pil = '';
        if($tingkat == 'a')
        {
            $pil = 'presiden';
        }
        elseif($tingkat == 'b')
        {
            $pil = 'dpd';
        }
        elseif($tingkat == 'c')
        {
            $pil = 'dprri';
        }
        elseif($tingkat == 'd')
        {
            $pil = 'dprprov';
        }
        elseif($tingkat == 'e')
        {
            $pil = 'dprkab';
        }
   		return view(Session::get('role').'.suaradesa.register', compact('prov', 'partai', 'tingkat', 'pil'));
    }

	function registerPostSuara(Request $request)
    {
        $validate = $this->validate($request, [
            'suarapartai' => 'required|array',
            'suarapartai.*' => 'integer',
            'suara' => 'array',
            'suara.*.*' => 'integer',
            'tingkat' => 'required'
        ],[ 'suarapartai.required' => 'Suara partai harus diisi!',
            'tingkat.required' => 'Tingkat harus diisi!',
        ]);

        $input = $request->all();
        $proses = new suaraDesaModel();

        $data = array();
        $req = array();

        foreach ($input['suarapartai'] as $id_partai => $value) 
        {
        	$data['suara'] = $value;
        	$data['caleg'] = null;
        	$data['partai'] = $id_partai;
        	$data['jenis'] = 'p';
	        $data['saksi'] = $input['saksi'];
	        $data['tingkat'] = $input['tingkat'];
            $data['kel'] = $input['kel'];

        	$proses->registerPost($data);
        	$req['suara_partai'] = "success";
        	unset($data);
        }

        if(!empty($input['suara']))
        {
            foreach ($input['suara'] as $id_partai => $suara) 
            {
                foreach ($suara as $id_caleg => $value) 
                {
                    $data = array();
                    $data['saksi'] = $input['saksi'];
                    $data['tingkat'] = $input['tingkat'];
                    $data['suara'] = $value;
                    $data['caleg'] = $id_caleg;
                    $data['partai'] = $id_partai;
                    $data['kel'] = $input['kel'];
                    $data['jenis'] = 'c';

                    $proses->registerPost($data);

                    unset($data);
                }

                $req['suara_caleg'] = "success";
            }
        }

        if($req['suara_partai'] == "success" || $req['suara_caleg'] == "success")
        {
            return $req;//'Sukses kirim suara!';
        }
        else
        {
            return 'Gagal kirim suara!';
        }
    }

    function getAllSuaraPartai($id_partai, $id_kel, $tingkat)
    {
    	$req = new suaraDesaModel();
		$req = $req->getAllSuaraPartai($id_partai, $id_kel, $tingkat);

		return $req;
    }

    function getAllSuaraPartaiBySaksi($id_partai, $id_kel, $id_saksi, $tingkat)
    {
    	$req = new suaraDesaModel();
		$req = $req->getAllSuaraPartaiBySaksi($id_partai, $id_kel, $id_saksi, $tingkat);

		return $req;
    }

    function getAllSuaraPartaiByDapil($id_partai, $id_kel, $id_saksi, $tingkat)
    {
    	$req = new suaraDesaModel();
		$req = $req->getAllSuaraPartaiByDapil($id_dapil, $id_partai);

		return $req;
    }

    function getAllSuaraCaleg($id_partai, $id_kel, $tingkat)
    {
    	$req = new suaraDesaModel();
		$req = $req->getAllSuaraCaleg($id_partai, $id_kel, $tingkat);

		return $req;
    }

    function getAllSuaraCalegBySaksi($id_partai, $id_kel, $id_saksi, $tingkat)
    {
    	$req = new suaraDesaModel();
		$req = $req->getAllSuaraCalegBySaksi($id_partai, $id_kel, $id_saksi, $tingkat);

		return $req;
    }

    function getAllSuaraCalegByDapil($id_dapil, $id_partai)
    {
    	$req = new suaraDesaModel();
		$req = $req->getAllSuaraCalegByDapil($id_dapil, $id_partai);

		return $req;
    }

    function updateSuara(Request $request)
    {
    	$validate = $this->validate($request, [
            'suarapartai' => 'required|array',
            'suarapartai.*.*' => 'integer',
            'suara' => 'array',
            'suara.*.*.*' => 'integer',
            'tingkat' => 'required'
        ],[ 'suarapartai.required' => 'Suara partai harus diisi!',
            'tingkat.required' => 'Tingkat harus diisi!',
        ]);

        $input = $request->all();
        $proses = new suaraDesaModel();

        $data = array();
        $req = array();

        foreach ($input['suarapartai'] as $id_partai => $value) 
        {
        	foreach ($value as $id => $values) 
        	{
		        $data['saksi'] = $input['saksi'];
		        $data['tingkat'] = $input['tingkat'];
        		$data['id'] = $id;
        		$data['suara'] = $values;
	        	$data['caleg'] = null;
	        	$data['partai'] = $id_partai;
                $data['kel'] = $input['kel'];
	        	$data['jenis'] = 'p';

	        	$proses->updateSuara($data);
	        	$req['suara_partai'] = "success";
	        	unset($data);
        	}
        }

        if(!empty($input['suara']))
        {
            foreach ($input['suara'] as $id_partai => $suara) 
            {
                foreach ($suara as $id_caleg => $value) 
                {
                    foreach ($value as $id => $values) 
                    {
                        $data = array();
                        $data['id'] = $id;
                        $data['saksi'] = $input['saksi'];
                        $data['suara'] = $values;
                        $data['caleg'] = $id_caleg;
                        $data['partai'] = $id_partai;
                        $data['kel'] = $input['kel'];
                        $data['jenis'] = 'c';
                        $data['tingkat'] = $input['tingkat'];

                        $proses->updateSuara($data);

                        unset($data);
                    }
                }

                $req['suara_caleg'] = "success";
            }
        }

        if($req['suara_partai'] == "success" || $req['suara_caleg'] == "success")
        {
            return $req;//'Sukses kirim suara!';
        }
        else
        {
            return 'Gagal kirim suara!';
        }
    }

    function viewSuara($tingkat)
    {
        $data = new dataModel();
        $prov = $data->getProv();
        $partai = $data->getPartai();
        $pil = '';
        if($tingkat == 'a')
        {
            $pil = 'presiden';
        }
        elseif($tingkat == 'b')
        {
            $pil = 'dpd';
        }
        elseif($tingkat == 'c')
        {
            $pil = 'dprri';
        }
        elseif($tingkat == 'd')
        {
            $pil = 'dprprov';
        }
        elseif($tingkat == 'e')
        {
            $pil = 'dprkab';
        }
    	return view(Session::get('role').'.suaradesa.view', compact('prov', 'partai', 'tingkat', 'pil'));
    }

    function deleteSuara(Request $request)
    {
    	$validate = $this->validate($request, [
        'suarapartai' => 'required|array',
        'suarapartai.*.*' => 'integer',
        'suara' => 'array',
        'suara.*.*.*' => 'integer'
        ],[ 'suarapartai.required' => 'Suara partai harus diisi!',
            'suara.' => 'Suara caleg harus diisi!',
        ]);

        $input = $request->all();
        $proses = new suaraDesaModel();

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

        if(!empty($input['suara']))
        {
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
        }   

        if($req['suara_partai'] == "success" || $req['suara_caleg'] == "success")
        {
            return $req;//'Sukses kirim suara!';
        }
        else
        {
            return 'Gagal kirim suara!';
        }
	}
}
