<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Request;
use \App\Models\User;

class VerifyBrrToken
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     * 
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->verify($request)) {
            return $next($request);
        }

        return response()->json( [ 'error' => 'Unauthorized' ], 403 );
    }


    /**
     * Verify token by querying database for existence of the client:token pair specified in headers.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function verify($request): bool //optional return types
    {
        if(!empty($request->bearerToken())){
        return User::select('remember_token')->where([    // add select so Eloquent does not query for all fields
            //'client' => $request->header('client'), // remove variable that is used only once
            'remember_token'  => $request->bearerToken(),  // remove variable that is used only once
        ])->exists();
        }
        else{
            return 0;
        }
    }
}