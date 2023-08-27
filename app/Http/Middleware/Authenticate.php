<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {

        if (! $request->expectsJson()) {
            //return route('login');
		    if($request->segment(1) == 'admin') {
		        return url('admin/login');
		        
		    }elseif($request->segment(1) == 'employee'){
				return url('employee/login');
				
			}elseif($request->segment(1) == 'franchise'){
				return url('franchise/login');
				
			}elseif($request->segment(1) == 'femployee'){
				return url('femployee/login');
				
			}elseif($request->segment(1) == 'parent'){
				return url('parent/login');
				
			}else{
				return route('login');
			}
        }
    }
}
