<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;
use Auth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $param)
    {
        $user_role = Auth::user()->role;

        $exp_param = explode('-',$param);

        $get_modules = DB::table('modules')->where('module_name',trim($exp_param[0]))->select('id')->first();

        
        if(isset($get_modules->id)){

            $get_permission_id = DB::table('module_details')->select('id')->where('module_id',$get_modules->id)->where('text',trim($exp_param[1]))->first();

            if(isset($get_permission_id->id)){

                $roles_permission = explode(',',get_role_permission($user_role));

                if(in_array($get_permission_id->id, $roles_permission)){

                    return $next($request);

                }else{
                    return redirect('/error-404');
                }
            }else{
                return redirect('/error-404');
            }
        }else{
            return redirect('/error-404');
        }
        
    }
}
