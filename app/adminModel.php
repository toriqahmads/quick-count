<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class adminModel extends Model
{
    function cekLogin($username)
    {
    	$data = DB::table('admin')
    			->select('admin.*')
    			->where('admin.username', $username)
    			->first();
    				
    	return $data;
    }
}
