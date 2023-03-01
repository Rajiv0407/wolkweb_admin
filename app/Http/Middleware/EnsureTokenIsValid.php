<?php

namespace App\Http\Middleware;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; 
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
        
            $token=authguard();

            if(empty($token)){
            return $this->errorResponse("Unauthenticated",401);
            }else if($token->isTrash==1){
             return $this->errorResponse("Your account has deactivated. Please contact to administrator.",401);
            }       

        return $next($request);
    }
}



   
  