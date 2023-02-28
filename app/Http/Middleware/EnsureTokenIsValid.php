<?php

namespace App\Http\Middleware;
use App\Http\Controllers\Controller;

use Closure;

class EnsureTokenIsValid extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next)
    {
         $authData=authguard();

            if(empty($authData)){
            return $this->errorResponse("Unauthenticated",401);
            }

        // if ($request->input('token') !== 'my-secret-token') {
        //     //echo "home" ;
        //     //return redirect('home');
        //     return $this->errorResponse("Unauthenticated",401);
        // }

        return $next($request);
    }
}
