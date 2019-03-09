<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class adminModel extends Model
{
    function cekLogin($username)
    {
    	$data = DB::table('admin')
    			->select('admin.*', 'admin_details.nama_depan', 'admin_details.nama_belakang', 'admin_details.hp')
    			->join('admin_details', 'admin_details.id', '=', 'admin.id_details')
    			->join('roles', 'roles.id', '=', 'admin.role_id')
    			->where('admin.username', $username)
    			->first();
    				
    	return $data;
    }

    function registerPost($data = array())
    {
        $fname = $data['fname'];
        $lname = $data['lname'];
        $pass = $data['password'];
        $uname = $data['username'];
        $telp = $data['telp'];

        $req = DB::select('CALL input_admin(?, ?, ?, ?, ?)', array($uname, $pass, $fname, $lname, $telp));

        return $req;
    }
}
