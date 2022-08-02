<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use Auth;
use Hash;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $registration_user=DB::table('users')->where('user_type', 3)->count();
        $active_user = DB::table('users')->where('user_type', 3)->where('status', 0)->count();
        $total_events = DB::table('events')->count();
        $total_created_events = DB::table('events')->count();
        $total_active_events = DB::table('events')->where('status',0)->count();
        $total_tribe = DB::table('tribes')->count();
        $total_inactive_acc= DB::table('users')->where('status',1)->count();

        //$users = User::join('roles','roles.id','=','users.role')->select('users.*','role_name')->orderBy('users.created_at','DESC')->get();

       // $roles = Roles::orderBy('created_at','DESC')->get();


       //$str2 = date('Y-m-d', strtotime('-7 days', strtotime($created_at)));
        $users=DB::table('users')->where('user_type',3)->get();
            //$str2 = date('Y-m-d', strtotime('-7 days', strtotime($created_at)));

        
        $code=DB::table('country')->select('iso3', 'phonecode')->get();
        $contact_details = DB::table('contact_us')->orderBy('id','DESC')->get();
        $approve = DB::table('user_approval')->get();

    
        //return view('user.user_list',compact('users','roles','code'));

        // print_r($total_events);
        // die;
        return view('dashboard', compact('registration_user','active_user', 'total_events','total_created_events','total_active_events','total_tribe','total_inactive_acc','users','code','contact_details','approve'));
        //return view('dashboard');
    }

    public function error()
    {
        return view('error_page');
    }

    public function change_pass_update(Request $request)
    {
        $user_id = Auth::user()->id;

        $request->validate([
            'old_password'=>'required',
            'new_password' => 'required|min:8|max:16',
            'con_password' => 'required_with:new_password|same:new_password|min:8|max:16'
        ]);

        $user_details = User::find($user_id);

        if(Hash::check($request->old_password, $user_details->password)){

            $get_old_passwords = DB::table('old_password')->where('email_id',$user_details->email)->orderBy('id','DESC')->take(3)->get();


            foreach($get_old_passwords as $old_pass)
            {
                if($old_pass->password == md5($request->new_password)){
                    return redirect()->back()->with('error','You Cannot Use Old Password As New Password');
                    die;
                }
            }

            DB::table('old_password')->insert([
                'email_id' => $user_details->email,
                'password' => md5($request->new_password)
            ]);

            $user_details->password = Hash::make($request->new_password);
            $user_details->save();
            return redirect()->back()->with('success','Password Updated Successfully');

           
        }else{

            return redirect()->back()->with('error','Current Password Does Not Matched');
        }
    }

  


}
