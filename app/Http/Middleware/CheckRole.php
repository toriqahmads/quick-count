<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    //const DELIMITER = '|';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {
        //$authRoles = explode(self::DELIMITER, $role);
        if(in_array($request->user()->hasRole(), $role))
        {
            return $next($request);
        }
        
        return redirect()->back()->with('alert', 'Anda tidak memiliki hak akses!');
    }
}
