<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use Validator;
use Session;
use DateTime;
use DB;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        // $get_country = DB::table('country')->select('id','name','nicename','iso3','phonecode','image')->orderby('id','ASC')->get();
        // foreach($get_country as $abc){
        // //$flag ="";
        // $flag ="https://sub.remnanttribe.org/public/country/".$abc->nicename.".png";
        // DB::table('country')->where('id',$abc->id)->update([
        //     'image' => $flag
        // ]);
        // }
        // die;

        // $r = "sudipta,somsasasasaassasasasa";
        // $a = substr($r, strpos($r, ",")+1);

        // echo $a;
        // exit;

        $users = User::join('roles','roles.id','=','users.role')->select('users.*','role_name')->orderBy('users.created_at','DESC')->get();

        $roles = Roles::orderBy('created_at','DESC')->get();

        $code=DB::table('country')->select('iso3', 'phonecode')->get();

        return view('user.user_list',compact('users','roles','code'));
    }

    public function user_update(Request $request)
    {
        $input = $request->all();
        // print_r($input);
        // die;

        $rules = [
            'first_name' => 'required|string',
            // 'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$request->user_id,
            'gender' => 'required|numeric',
            'user_name'=>'required',
            'user_id' => 'required|numeric',
            'role' => 'required|numeric',
            'm_number' => 'required|numeric',
            'c_code' => 'required'

        ];

        $validate = Validator::make($input,$rules);

        if ($validate->fails()) {
            return response()->json([
                'status' => 1,
                'message' => 'Error Occured',
                'errors' => $validate->errors()
            ]);
        }

        $user = User::find($input['user_id']);
        $user->full_name = $input['first_name'];
        // $user->last_name = $input['last_name'];
        $user->user_name = $input['user_name'];
        $user->gender = $input['gender'];
        $user->email = $input['email'];
        $user->role = $input['role'];
        $user->mobile_no = $input['m_number'];
        $user->country_code = '+'.$input['c_code'];

        $user->save();

        $fetch_userinfo = DB::table('user_info')->where('user_id' , $input['user_id'])->get()->toArray();

        if(!empty($fetch_userinfo)){
            
        $user_info_update = DB::table('user_info')->where('user_id' , $input['user_id'])
        ->update([
            'new_believer' => $request->beliver,
            'understanding_dreams' => $request->dreams,
            'need_prayer' => $request->prayer,
            'ques_about_jesus' => $request->question,
            'event_attend' => $request->event,
            'holy_spirit' => $request->holy_spirit

        ]);
    }else{
        $user_info_update = DB::table('user_info')
        ->insert([
            'user_id' => $user->id,
            'new_believer' => $request->beliver,
            'understanding_dreams' => $request->dreams,
            'need_prayer' => $request->prayer,
            'ques_about_jesus' => $request->question,
            'event_attend' => $request->event,
            'holy_spirit' => $request->holy_spirit
        ]);
    }

         
        return response()->json([
            'status' => 0,
            'a' =>$user,
            'message' => 'User Registered Succesfully.'
        ], 200);
        
    }

    public function admin_update(Request $request)
    {
        $input = $request->all();
        // print_r($input);
        // die;

        $rules = [
            'first_name' => 'required|string',
            // 'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$request->user_id,
            'gender' => 'required|numeric',
            'user_name'=>'required',
            'user_id' => 'required|numeric',
            'role' => 'required|numeric',
            'mob_number' => 'required|unique:users,mobile_no,'.$request->user_id,
            'c_code' => 'required'


        ];

        $validate = Validator::make($input,$rules);

        if ($validate->fails()) {
            return response()->json([
                'status' => 1,
                'message' => 'Error Occured',
                'errors' => $validate->errors()
            ]);
        }

        $user = User::find($input['user_id']);
        $user->full_name = $input['first_name'];
        // $user->last_name = $input['last_name'];
        $user->user_name = $input['user_name'];
        $user->gender = $input['gender'];
        $user->email = $input['email'];
        $user->role = $input['role'];
        $user->mobile_no = $input['mob_number'];
        $user->country_code = '+'.$input['c_code'];
        $user->save();
         
        return response()->json([
            'status' => 0,
            'a' =>$user,
            'message' => 'User registered succesfully.'
        ], 200);
        
    }

    public function logout(Request $request)
    {
        Session::flush();

        return redirect('admin/login');
    }


    public function delete_user(Request $request)
    { 

        $user = User::find($request->user_id);

        $user->delete();

        if($user){
            return response()->json(['status' => 1]);
        }else{
            return response()->json(['status' => 0]);
        }
       
    }

    public function update_status(Request $request)
    {
        $user = User::find($request->user_id);
        $user->status = $request->update;
        
        if( $user->save()){
            return response()->json(['status'=>1]);
        }else{
            return response()->json(['status'=>0]);
        }
    }


    public function user_add()
    {
        $roles = Roles::orderBy('created_at','DESC')->get();
        $code= DB::table('country')->select('iso3', 'phonecode')->get();


        return view('user.add_users',compact('roles','code'));
    }


    public function store(Request $request)
    {
        $input = $request->all();

        // Session::flush('first_name',$request->first_name);
        // Session::flush('email',$request->email);
        // Session::flush('gender',$request->gender);mobile_no
        // Session::flush('role',$request->role);

    


        $rules = [
            'first_name' => 'required|string|max:255',
            //'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'gender' => 'required|numeric',
            'user_name'=>'required|max:255',
            'role' => 'required|numeric',
            'cuntry_code' =>'required',
            'mobile_no' =>'required|digits:10|unique:users,mobile_no',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:16',             // must be at least 8 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],

            // 'beliver' =>'required',
            // 'dreams' =>'required',
            // 'prayer' =>'required',
            // 'question' =>'required',
            // 'event' =>'required',

        ];


        $messages = [
            'password.required'=>'Password Is Required',
            'password.string' => 'Password Must Be a Alphanumeric Combination',
            'password.min' => 'Password Must Be a Contain 8 Character',
            'password.max' => 'Password Is Too Long, Maximum 16 Character Are Allow',
            'password.regex' => 'Password Must Contain At Least One Lowercase Letter, One Uppercase Letter, One Digit, a Special Character',
        ];
            

        

        $validate = Validator::make($input,$rules,$messages);

        if ($validate->fails()) {

            Session::put('first_name', $request->first_name);
            Session::put('email', $request->email);
            Session::put('gender', $request->gender);
            Session::put('role', $request->role);
            Session::put('mobile_no', $request->mobile_no);

            return redirect()->back()->withErrors($validate->errors());
        }


        // print_r($request->all());
        // die;

        $user = User::create([
            'full_name' => $request->first_name,
            //'last_name' => $request->last_name,
            'email'=>$request->email,
            'user_name'=>$request->user_name,
            'gender'=>$request->gender,
            'password' => Hash::make($request->password),
            'role'=>$request->role,
            'mobile_no' =>$request->mobile_no,
            'country_code'=>'+'.$request->cuntry_code,

            'is_deleted'=>'N'
        ]);
        // $last_id = DB::getPdo()->lastInsertId();
        
        // $user_info_update = DB::table('user_info')
        // ->update([
        //     'user_id' => $user->id,
        //     'new_believer' => $request->beliver,
        //     'understanding_dreams' => $request->dreams,
        //     'need_prayer' => $request->prayer,
        //     'ques_about_jesus' => $request->question,
        //     'event_attend' => $request->event

        // ]);

        if($user){
            
            DB::table('old_password')->insert([
                'email_id' => $request->email,
                'password' => md5($request->password)
            ]);

        
           
            
            return redirect('admin/user-management')->with('success','User Successfully Created');
            
        }

        


    }


    public function member_list_view()
    {
        
        $users = User::where('user_type',3)->orderBy('users.created_at','DESC')->get();
        $code= DB::table('country')->select('iso3', 'phonecode')->get();

        return view('user.member_list',compact('users','code'));
    }

    public function fetch_alldata(Request $request)
    {
        $id =$request->id;
       $alldata=DB::table('users')
       ->leftJoin('user_info', 'users.id', '=', 'user_info.user_id')
       ->where('users.id',$id)
       ->first();
       return response()->json($alldata);
   
    }

    public function contact_manage()
    {
        // $code=DB::table('country')->select('iso3', 'phonecode')->get();
        // return view('member_list', compact("code"));
        $contact_details = DB::table('contact_us')->orderBy('id','DESC')->get();

        return view('contact_manage', compact('contact_details'));
        
    }

    public function user_approval()
    {
        $approve = DB::table('user_approval')->leftJoin('users', 'user_approval.user_id', '=', 'users.id')->get();

        // echo "<pre>";
        // print_r($approve);
        // die;

        return view('user_approval', compact('approve'));

    }

    public function user_approve_status_update(Request $request)
    {
        // $update = DB::table('user_approval')->select('approval_status')->get();

        // if('approval_status' == 0){
        //     DB::table('user_approval')->update([
        //         'approval_status' => 1
        //     ]);
        // }
        // elseif ('approval_status' == 1) {
        //     DB::table('user_approval')->update([
        //         'approval_status' => 0
        //     ]);
        // }

        
        
        $update = DB::table('user_approval')->where('id',$request->id)->update([
            'approval_status' =>$request->update
        ]);

        if($update){
            return response()->json(['approval_status'=>1]);
        }else{
            return response()->json(['approval_status'=>0]);
        }
    }
   

    public function last_week_active_user()
    {
        //$today=date('y:m:d');

        $lastWeek = date("y-m-d", strtotime("-7 days"));

        // print_r($lastWeek);
        // die;
        $users=DB::table('users')->where('user_type',3)->where('created_at','>=', $lastWeek )->get();

        return view('active_user_last_week', compact('users'));

    }


    
}
