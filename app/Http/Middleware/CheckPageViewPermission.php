<?php

namespace App\Http\Middleware;

 
use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Route as LaravelRoute;


class CheckPageViewPermission
{
    // public function handle($request, Closure $next)
    // {
        
		// if (Route::currentRouteName() !== 'home' && !Gate::allows('view-page')) {
            // session()->flash('message', 'Access denied! You do not have permission to access this page.');
            // session()->flash('messageClass', 'errorClass');
            // return redirect()->route('home');
        // }
		

        // return $next($request);
    // }

}
