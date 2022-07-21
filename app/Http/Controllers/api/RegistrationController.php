<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException; 
use App\Models\User;
use App\Models\User_temp;
use Carbon\Carbon;
use Validator;
use Hash;
use DB;
use Illuminate\Support\Facades\Log;

class RegistrationController extends Controller
{
    public function registration_store(Request $request)
    {
        $input = $request->all();


        // //return response()->json($_FILES);

         //Log::debug(print_r($_FILES,true));
        // Log::debug(print_r($request->all(),true));
        // //echo "<pre>";
        // //print_r($->all());
        // die;

        
        $image_name="user-image.png";
        $destination = storage_path('app/public/profile_pic/');
        $allow_image_mime_type = ['image/jpeg','image/jpg','image/png'];
        $allow_image_ext = ['jpeg','jpg','png'];

        $rules = [
            'full_name' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users_temp',
            'mobile_no' => 'required|digits:10|unique:users,mobile_no',
            'user_name' => 'required|unique:users,user_name',
            'profile_pic' => 'required',
            'type' => 'required',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registration Failed',
                'errors' => $validator->errors()
            ]);
        }


       
        // if(!empty($_FILES['file']['name'])){
        //     $get_image   = $request->file('file');
        //     $image_mime_type  = $get_image->getMimeType();
        //     $image_ext   = $get_image->getClientOriginalExtension();

        //     if (in_array($image_mime_type, $allow_image_mime_type)) {

        //         if(in_array($image_ext, $allow_image_ext)){

        //             $image_name = time().rand(1111,9999).".".$image_ext;

        //             $get_image->move($destination,$image_name);

        //         }
                
        //     }
        // }

       
        if(!empty($request->profile_pic)){
            $exp = explode('/',$request->type);
            $image_name =time().rand(1111,9999).'.'.end($exp);

            $image_path = substr($request->profile_pic, strpos($request->profile_pic, ",")+1);

            $destination = $destination.$image_name;
            //echo base64_decode($request->profile_pic);
            @file_put_contents($destination,base64_decode($image_path));
        }

       
        $user_temp = DB::table('users_temp')->insert([
            'full_name' => $input['full_name'],
            'email' => $input['email'],
            'mobile_no' => $input['mobile_no'],
            'country_code' => $input['country_code'],
            'user_name' => $input['user_name'],
            'is_deleted' => 'N',
            'role' => 0,
            'user_type' =>3,
            'profile_image'=>$image_name
            
        ]);

        $id = DB::getPdo()->lastInsertId();

        $receiverNumber = $input['country_code'].trim($input['mobile_no']);

        $otp = rand(1111,9999);

        $message = "Dear ".$input['full_name']. ", Your OTP is : ".$otp." for Remnant Tribe Registration.";

        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_TOKEN");
        $twilio_number = getenv("TWILIO_FROM");

       
           
        try{ 
            $client = new Client($account_sid, $auth_token);
            
            if($client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message])){
            
                }

                
        }catch(TwilioException $e){

            DB::table('users_temp')->where('id',$id)->delete();

            return response()->json([
                'success' => false,
                'message' => 'Mobile Number is Invalid',
            ]);
        }

        DB::table('users_temp')->where('mobile_no',trim($input['mobile_no']))->update([
            'otp'=> $otp,
        ]);
         
        return response()->json([
            'success' => true,
            'message' => 'User registered succesfull.Otp has been sent to your mobile no',
             'mobile_no' => $input['mobile_no'],
             'otp' => $otp,
             //'id' => $id
        ], 200);
    }



    // public function registration_store(Request $request)
    // {
    //     $input = $request->all();

    //     $rules = [
    //         'first_name' => 'required|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'gender' => 'required|numeric',
    //         'user_name'=>'required|unique:users,user_name',
    //         'email' => 'required|email|unique:users',
    //         'mobile_no' => 'required|digits:10|unique:users,mobile_no',
    //     ];

    //     $validator = Validator::make($input, $rules);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Registration Failed',
    //             'errors' => $validator->errors()
    //         ]);
    //     }

       
    //     $user = User::create([
    //         'first_name' => $input['first_name'],
    //         'last_name' => $input['last_name'],
    //         'user_name' => $input['user_name'],
    //         'gender'=>$input['gender'],
    //         'email' => $input['email'],
    //         'mobile_no' => $input['mobile_no'],
    //         'is_deleted' => 'N',
    //         'role' => 0,
    //         'user_type' =>3
            
    //     ]);
         
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'User registered succesfully.'
    //     ], 200);
    // }


    public function registration_otp_verify(Request $request)
    {
        $input = $request->all();

        $rules = [
            'otp'=>'required|max:4|min:4',
            'mobile_no' => 'required|digits:10',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Registration Failed',
                'errors' => $validator->errors()
            ]);
        }

        $otp_verify = DB::table('users_temp')->where('mobile_no',trim($input['mobile_no']))->where('otp',$input['otp'])->orderBy('id','DESC')->first();

        if(!empty($otp_verify->id)){

            //$get_data = DB::table('users_temp')->where('id', $request->id)->first();
            
                $user=User::create([
                'full_name' => $otp_verify->full_name,
                'email' => $otp_verify->email,
                'mobile_no' => $otp_verify->mobile_no,
                'country_code' => $otp_verify->country_code,
                'user_name' => $otp_verify->user_name,
                'is_deleted' => 'N',
                'role' => 0,
                'user_type' =>3,
                'profile_image'=>$otp_verify->profile_image,
                'otp' => '',
                'registration_verify'=>1
                
            ]);
        
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;

            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

            User::where('id',$user->id)->update([
                'last_login_at' => Carbon::now(),
                'remember_token'=>$tokenResult->accessToken,
                'otp' => ''
            ]);

            return response()->json([
                'status'=>true,
                'message' => 'Otp is verified.You have successfully register',
                //'data' => $get_data,
                'id' => $user->id,
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                

            ]);

           // DB::table('users_temp')->where('id', $request->id)->delete();

        // }else{
        //     return response()->json([
        //         'status'=>false,
        //         'message'=>"Registration Faild .Please try again..."
                
        //     ]);
            
        // }


            // 'expires_at' => Carbon::parse(
            //     $tokenResult->token->expires_at
            // )->toDateTimeString()

        }else{
            return response()->json([
                'status'=>false,
                'message'=>"Incorrect Otp.Please try again..."
                
            ]);
        }
    }
}
