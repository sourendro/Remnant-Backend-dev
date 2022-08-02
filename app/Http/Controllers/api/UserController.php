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
            $link=url('/').'/storage/app/public/profile_pic/';
            
            $user =DB::table('users')->select('id','full_name','email','mobile_no','country_code','profile_image','last_login_at')
            ->where('remember_token',$request->bearerToken())->get(); 
            //print_r($request->bearerToken()) ;
            //echo $user;
            $abc = array();
            foreach($user as $img){
            
                $image ="";
                $image = $link.$img->profile_image;
                //$thumbnail = $link.$video->video_thumbnail;
                $abc[] = array('id'=>$img->id,'full_name'=>$img->full_name,'email'=>$img->email,'mobile_no'=>$img->mobile_no,'country_code'=>$img->country_code,'last_login_at'=>$img->last_login_at,'profile_image'=>$image);
                                
        }

        return response()->json($abc);

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

   public function user_approval(Request $request)
   {
      $input = $request->all();

      $rules = [
         'user_id'=>'required',
         'group_id' => 'required'
      ];

         $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed',
                'errors' => $validator->errors()
            ]);
        }

        $approve = DB::table('user_approval')
        ->insert([
            'user_id' => $request->user_id,
            'group_id' => $request->group_id
        ]);

        if($approve){
         return response()->json([
             'status'=>true,
             'message' => 'Successfully Insert'
         ]);
         }else{
             return response()->json([
                 'status'=>false,
                 'message' => 'Faild to Insert'
             ]);  
         }


   }

   public function get_details_using_phon_no(Request $request)
   {
    //$input = $request->mobile_no;
        $link=url('/').'/storage/app/public/profile_pic/';
    // return response()->json([
    //         'data' =>$request->mobile_no
    //     ]);
    //     die;
        // $rules = [
        //     'mobile_no'=>'required'
        // ];

        // $validator = Validator::make($input, $rules);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Faild',
        //         'errors' => $validator->errors()
        //     ]);
        // }
        $valid = array();
        $invalid = array();
        for($i = 0; $i < count($request->mobile_no); $i++){

            $details = DB::table('users')->select('id','full_name','profile_image','mobile_no')->where('user_type',3)->where('mobile_no', $request->mobile_no[$i])->first();

            if(!empty($details)){
                $valid[]= array('id'=>$details->id,'full_name'=> $details->full_name,'mobile_no'=>$details->mobile_no,'profile_image'=>$link.$details->profile_image);
            }else{
                $invalid[]=array($request->mobile_no[$i]);
            }
        }

        return response()->json([
                    'data' =>$valid
                ]);
    //die;

    //     $abc = array();
    //     foreach($details as $details){
           
    //            $get_image ="";
    //            $get_image = $link.$details->profile_image;
    //            $abc[] = array('id'=>$details->id,'full_name'=>$details->full_name,'profile_image'=>$get_image);                                 
    //    }

    //    return response()->json([
    //     'status'=>true,
    //     'data' => $abc
    // ]);

    // if($details){
    //     return response()->json([
    //         'status'=>true,
    //         //'message' => 'successfull',
    //         'data' => $abc
            
    //     ]);
    // }else{
    //     return response()->json([
    //         'status'=>false,
    //         'message' => 'faild'
    //     ]);  
    // }

   }


}
