<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class UserController extends Controller
{
   public function index(Request $request)
   {

    $user =DB::table('users')->select('full_name','email','mobile_no','country_code','profile_image','last_login_at')
    ->where('remember_token',$request->bearerToken())->get(); 
     //print_r($request->bearerToken()) ;
    //echo $user;
    return response()->json($user);

   }

   public function valid_user(Request $request)
   {
      $input = $request->all();

      $rules = [
         'country_code'=>'required',
         'mobile_no' => 'required|digits:10',
      ];

         $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed',
                'errors' => $validator->errors()
            ]);
        }

        $mobile_no_check = DB::table('users')->where('mobile_no',trim($input['mobile_no']))->where('country_code',trim($input['country_code']))->get()->toArray();

         if(!empty($mobile_no_check)){

         return response()->json([
            'status'=>true,
            'message'=>"mobile no exist",
            ]);
         }else{
         return response()->json([
            'status'=>false,
            'message'=>"mobile no NOT exist",
            ]);
         }
     
   }

}
