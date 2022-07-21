<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LoginAttempt;
use DB;
use Hash;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{

    public function index()
    {
        return view('login');
    }

    public function login_verify(Request $request)
    {
        $max_login_attempt = 3;

        $request->validate([
            'email' => 'required|email',
            'password' => 'required', 
        ],
        [
            'email.required'=>'Email id is required',
            'email.email'=>'Email id is invalid',
            'password.required'=>'Password is required',

        ]);

        $email = $request->email; 
        $password = $request->password; 

       
        $get_login_attempt = LoginAttempt::where('status',0)->where('email', $request->email)->where('ip_address',$request->ip())->where('time','>=',Carbon::now()->subMinutes(15))->get()->toArray();

        if(count($get_login_attempt) <= ($max_login_attempt -1 )){   
            if (Auth::attempt(array('email' => $email, 'password' => $password, 'status'=>0,'is_deleted'=>'N'))){
             
                LoginAttempt::where('status',0)->where('ip_address',$request->ip())->where('email', $request->email)->update([
                    'status'=>1
                ]);
                return redirect('admin/dashboard');
               
            } else{
    
                LoginAttempt::create([
                    'ip_address' => $request->ip(),
                    'time'=>Carbon::now(),
                    'email' => $request->email
                ]);

                $rest = $max_login_attempt - (count($get_login_attempt)+1);

                if(empty($get_login_attempt)){
                    $rest = $max_login_attempt - 1;
                }

                $error_msg = "Email id Or Password Does Not Match.
                You Have ".$rest." Attempt Left";
                if($rest == 0){
                    return back()->with('error', 'Too Many Login Attempts, Please Try Again After 15 Minutes');
                }else{
                    return back()->with('error', $error_msg);
                }
    
                
            }
        } else {

            return back()->with('error', 'Too Many Login Attempts, Please Try Again After 15 Minutes');
        }
        
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }


    public function forget_password()
    {
        return view('forget_password');
    }


    public function forget_password_submit(Request $request)
    {
        $hostname = env('MAIL_FROM_ADDRESS');

        $request->validate([
            'email' => 'required|email|max:255'
        ]);
       
        $check_if_registerd = DB::table('users')->where('email',trim($request->email))->first();



        if(isset($check_if_registerd->id)){

            $name = $check_if_registerd->full_name;

            $token = rand();

            $link = url('/').'/'.base64_encode($token).'/reset-password';

            $html = '<table cellspacing="0" border="0" cellpadding="0" width="100%" style="font-family: "Poppins", sans-serif;">
            <tr>
                <td>
                    <table cellspacing="0" border="0" cellpadding="0">
                    <tr>
                        <td>'.'Dear '.$name.','.'</td>
                    </tr>
                    </table>

                    <table cellspacing="0" border="0" cellpadding="0">
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;We received a request for a password change on your Remnant Tribe Admin Account.You can reset your password just click on this link</td>
                            
                        </tr>
                        <tr>
                        <td><a href="'.$link.'">'.$link.'</a></td>
                        </tr>
                        <tr>
                        <td>--Thank You</td>
                        </tr>
                    
                    </table>
                </td>
            </tr>
        </table>';

        $html='<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Reset Password Link</title>
        </head>
        <body>
            <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
                <div class="box" style="width:80%; margin: 0 auto; border: 1px solid rgba(0, 0, 0, 0.212); padding: 30px 80px;">
                    <div style="font-size: 20px; color: gray;">
                        <p>Hello '.$name.', </p>
                        <p>We\'ve received a request to reset the password for your Remnant Tribe account associated with '.$request->email.'. No changes have been made to your account yet.</p>
                        <p>You can reset your password by clicking the link below:</p>
                        <a href="'.$link.'" style="text-decoration: none; background-color: blue; width: 35%;margin: 0 auto; display: block; color: #fff; padding: 10px 20px; border-radius: 5px; text-align: center;">Reset your password</a>
                        <p>If you did not request a new password, you can ignore this email.Your password will not be changed</p>
                        
                        <p>- Remnant Tribe Network Administrator</p>
                    </div>
                </div>
            </div>
        </body>
        </html>';


            try {
                $maildata['messagebody_foruser'] = $html;
                $maildata['toemail'] =  $request->email;
                $maildata['fromemail'] = $hostname;
                $mail_send = Mail::send(array(), $maildata, function ($message) use ($maildata) {
                    $message->to($maildata['toemail'])
                        ->subject('Forget Password')
                        ->from($maildata['fromemail'], 'Remnant Tribe Network')
                        ->setBody($maildata['messagebody_foruser'], 'text/html');
                });

                
                    DB::table('users')->where('id',$check_if_registerd->id)->update([
                        'remember_token' => $token
                    ]);
                    return back()->with('success', 'An Email Has Been Sent To Your Registerd Email ID.');
                
                    
                
            } catch (Exception $e) {

                return back()->with('error', 'Some Error Occured While Sending The Mail. Please Try Again Later...');
            }
        }else{
            return back()->with('error', 'This Email id Is Not Registed With Us');
        }

    }


    public function reset_password(Request $request, $id)
    {
        if(isset($id)){

            $id = base64_decode($id);

            if(is_numeric($id)){

                $get_user_details = DB::table('users')->where('remember_token',$id)->first();

               if(!empty($get_user_details)){
                    return view('reset_password',compact('id'));
               }else{
                    return redirect('/forget-password')->with('error','Token Is Expire.');
               }
            }else{
                return redirect('/forget-password')->with('error','Token Is Expire.');
            }
        }else{
            return redirect('/forget-password')->with('error','Token Is Expire.');
        }
    }


    public function reset_password_submit(Request $request)
    {
        $request->validate([
            'key'=>'required|numeric',
            'new_password' => 'required|min:8|max:16',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'max:16',             // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'confirm_password' => 'required_with:new_password|same:new_password|min:8|max:16'
        ],
        [
            'confirm_password.same' => 'The confirm password and the new password should be matched.',
            'confirm_password.min' =>'The confirm password must have at least 8 characters'
        ]
    
    );

        $get_user_details = DB::table('users')->where('remember_token',$request->key)->first();

        if(isset($get_user_details->id)){

            $get_old_passwords = DB::table('old_password')->where('email_id',$get_user_details->email)->orderBy('id','DESC')->take(3)->get();


            foreach($get_old_passwords as $old_pass)
            {
                if($old_pass->password == md5($request->new_password)){
                    return redirect()->back()->with('error','You Cannot Use Old Password As New Password');
                    die;
                }
            }

            $update = DB::table('users')->where('id',$get_user_details->id)->update([
                'password' => Hash::make($request->new_password),
                'remember_token' => ''
            ]);

            if($update){
                DB::table('old_password')->insert([
                    'email_id' => $get_user_details->email,
                    'password' => md5($request->new_password)
                ]);

                return redirect('/')->with('success',"Password Has Been Reset, Lets Login");
            }else{
                return back()->with('error','Something Wents Wrong');
            }
        }else{
            return back()->with('error','Something Wents Wrong');
        }
    }
}
