<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Validator;
//use Carbon\Carbon;
use Hash;
use DB;

use Twilio\Rest\Client;

class AuthController extends Controller
{
  
    
    public function member_login(Request $request)
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
                'message' => 'Login Failed',
                'errors' => $validator->errors()
            ]);
        }
       

        $mobile_no_check = DB::table('users')->where('mobile_no',trim($input['mobile_no']))->get()->toArray();

        if(!empty($mobile_no_check)){
            $receiverNumber = $input['country_code'].trim($input['mobile_no']);

            $otp = rand(1111,9999);
            $message = "Dear ".$mobile_no_check[0]->full_name.", Your OTP is : ".$otp." for Remnant Tribe.";
    
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);

            DB::table('users')->where('mobile_no',trim($input['mobile_no']))->update([
                'otp'=> $otp,
                'last_login_at'=>date('Y-m-d h:i:s')
            ]);

            return response()->json([
                'status'=>true,
                'message'=>"OTP Sent to your mobile number",
                'otp' => $otp
            ]);
    
           
        }else{
            return response()->json([
                'status'=>false,
                'message'=>"Mobile No does not exixts",
                'new_user' =>true
            ]);
        }
       

        // $user = $request->user();zkfYJOKFx9V
        // $tokenResult = $user->createToken('Personal Access Token');
        // $token = $tokenResult->token;

        // if ($request->remember_me)
        //     $token->expires_at = Carbon::now()->addWeeks(1);
        // $token->save();

        // User::where('id',$user->id)->update([
        //     'last_login_at' => Carbon::now(),
        //     'api_token'=>$tokenResult->accessToken
        // ]);

        // return response()->json([
        //     'status'=>true,
        //     'access_token' => $tokenResult->accessToken,
        //     'token_type' => 'Bearer',
        //     'expires_at' => Carbon::parse(
        //         $tokenResult->token->expires_at
        //     )->toDateTimeString()
        // ]);
    }
  
    // public function userName_email_verify(Request $request)
    // {   
    //     $checkEmail = User::where('email',$request->email)->count();

    //     $checkUserName = User::where('user_name',$request->userName)->count();

    //     return response()->json(['email'=>$checkEmail, 'userName'=>$checkUserName]);
    // }


    // public function logout(Request $request)
    // {
    //     $user_id = Auth::user()->id;

    //     $request->user()->token()->revoke();

    //     User::where('id',$user_id)->update([
    //         'api_token'=>NULL
    //     ]);

    //     return response()->json([
    //         'status'=>true,
    //         'message' => 'Successfully logged out'
    //     ]);
    // }


    public function otp_verify(Request $request)
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
                'message' => 'Login Failed',
                'errors' => $validator->errors()
            ]);
        }

        $otp_verify = DB::table('users')->where('mobile_no',trim($input['mobile_no']))->where('otp',$input['otp'])->get()->toArray();

        if(!empty($otp_verify)){

            $user = User::find($otp_verify[0]->id);
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
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
            ]);


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

    public function other_details(Request $request)
    {
        $input = $request->all();

        // $rules = [
        //     'beliver'=>'required',
        //     'dreams' => 'required',
        //     'prayer' => 'required',
        //     'question' => 'required',
        //     'event' => 'required',
        // ]; 

        // $validator = Validator::make($input, $rules);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Failed',
        //         'errors' => $validator->errors()
        //     ]);

        // }

        $user_info_update = DB::table('user_info')
        ->insert([
            //'user_id' => $user->id,
            'user_id' => $request->id,
            'new_believer' => $request->beliver,
            'understanding_dreams' => $request->dreams,
            'need_prayer' => $request->prayer,
            'ques_about_jesus' => $request->question,
            'event_attend' => $request->event,
            'holy_spirit' => $request->holy_spirit
        ]);

        $gender_update = DB::table('users')->where('id' , $input['id'])
        ->update([
            'gender' => $request->gender

        ]);

        return response()->json([
            'success' => true,
            'message' => 'User registered succesfull',
        ], 200);


    }



    public function resend_otp(Request $request)
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
                'message' => 'Otp Send Failed',
                'errors' => $validator->errors()
            ]);
        }
       

        $mobile_no_check = DB::table('users_temp')->where('mobile_no',trim($input['mobile_no']))->get()->toArray();

        if(!empty($mobile_no_check)){

            $receiverNumber = $input['country_code'].trim($input['mobile_no']);

            //$otp = rand(1111,9999);
            $otp = DB::table('users_temp')->select('otp')->where('mobile_no',$input['mobile_no'])->orderBy('id','DESC')->first();

            $message = "Dear ".$mobile_no_check[0]->full_name.", Your OTP is : ".$otp->otp." for Remnant Tribe. ";
    
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);

            // DB::table('users_temp')->where('mobile_no',trim($input['mobile_no']))->update([
            //     'otp'=> $otp,
            // ]);

            $get_resend_attempt = DB::table('reg_resend_attemp')->where('mobile_no', $request->mobile_no)->where('created_at','>=',Carbon::now()->subMinutes(30))->get()->toArray();
            // return response()->json([
            //     $get_resend_attempt
            // ]);
            
            if(count($get_resend_attempt) < 3){
                DB::table('reg_resend_attemp')->insert([
                    'mobile_no' => $request->mobile_no,
                    'otp' =>$otp->otp
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>"Maximum OTP send . Please try after 30 munite.",
                ]);
            }

 


            return response()->json([
                'status'=>true,
                'message'=>"OTP Sent to your mobile number",
                'otp' => $otp->otp
            ]);
    
           
        }else{
            return response()->json([
                'status'=>false,
                'message'=>"Mobile No does not exixts"
            ]);
        }
    }


    public function resend_otp_login(Request $request)
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
                'message' => 'Otp Send Failed',
                'errors' => $validator->errors()
            ]);
        }
       

        $mobile_no_check = DB::table('users')->where('mobile_no',trim($input['mobile_no']))->get()->toArray();

        if(!empty($mobile_no_check)){

            $receiverNumber = $input['country_code'].trim($input['mobile_no']);

            //$otp = rand(1111,9999);
            $otp = DB::table('users')->select('otp')->where('mobile_no',$input['mobile_no'])->orderBy('id','DESC')->first();

            $message = "Dear ".$mobile_no_check[0]->full_name.", Your OTP is : ".$otp->otp." for Remnant Tribe.";
    
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);

            // DB::table('users')->where('mobile_no',trim($input['mobile_no']))->update([
            //     'otp'=> $otp,
            // ]);
            
            //FOR LOGIN ATTEMPT
            $get_login_resend_attempt = DB::table('login_resend_attemp')->where('mobile_no', $request->mobile_no)->where('created_at','>=',Carbon::now()->subMinutes(30))->get()->toArray();
            // return response()->json([
            //     $get_resend_attempt
            // ]);
            
            if(count($get_login_resend_attempt) < 3){
                DB::table('login_resend_attemp')->insert([
                    'mobile_no' => $request->mobile_no,
                    'otp' =>$otp->otp
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                    'message'=>"Maximum OTP send . Please try after 30 munite.",
                ]);
            }


            return response()->json([
                'status'=>true,
                'message'=>"OTP Sent to your mobile number",
                'otp' => $otp->otp
            ]);
    
           
        }else{
            return response()->json([
                'status'=>false,
                'message'=>"Mobile No does not exixts"
            ]);
        }
    }
}
