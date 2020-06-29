<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin_login
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle( $request, Closure $next)
    {
        if (session('admin_email')==='admin@zerocache.com' && session('admin_password')==='123456789'){
            return $next($request);
        }
        abort(404);
    }
}
