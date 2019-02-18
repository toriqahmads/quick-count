<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'roles';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    function saksi()
    {
        return $this->hasMany(Saksi::class);
    }

    function admin()
    {
        return $this->hasMany(Admin::class);
    }
}
