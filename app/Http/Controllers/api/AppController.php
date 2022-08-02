<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Validator;
use Hash;
use DB;
use Illuminate\Support\Facades\Mail;

class AppController extends Controller
{
    public function country_flag(Request $request)
    {
        // $get_country = DB::table('country')->select('id','name','nicename','iso3','phonecode','image')->orderby('id','ASC')->get();
        // foreach($get_country as $abc){
        // //$flag ="";
        // $flag ="https://ec2-52-53-161-255.us-west-1.compute.amazonaws.com/country/".$abc->nicename.".png";
        // DB::table('country')->where('id',$abc->id)->update([
        //     'image' => $flag
        // ]);
        // }
        // die;
        
        $get_country = DB::table('country')->select('name','nicename','iso3','phonecode','image')->get();

        return response()->json($get_country);
    }


    public function contact_us(Request $request)
    {
        $input = $request->all();

        $rules = [
                'name'=>'required',
                'contact_no' => 'required',
                'email' => 'required',
                'message' => 'required',
            ];
            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed',
                        'errors' => $validator->errors()
                    ]);        
                }
        $contact = DB::table('contact_us')
        ->insert([
            'contact_name' => $request->name,
            'contact_no' => $request->contact_no,
            'contact_email' => $request->email,
            'contact_message' => $request->message,
        ]);

        $hostname = env('MAIL_FROM_ADDRESS');

        $html='<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>contact us </title>
        </head>
        <body>
            <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
                <div class="box" style="width:80%; margin: 0 auto; border: 1px solid rgba(0, 0, 0, 0.212); padding: 30px 80px;">
                    <div style="font-size: 20px; color: gray;">
                        <p>Hello Administrator, </p>
                        <p>We\'ve received a Email From '.$request->email.' For Contact Us Form .</p>
                        <p> Details </p>
                        <p> Display Name : '.$request->name. '</p>
                        <p> Contact No : '.$request->contact_no.'</p>
                        <p> Email : '.$request->email.'</p>                       
                        <p> Message : '.$request->message.'</p>
                        <p>- Remnant Tribe</p>
                    </div>
                </div>
            </div>
        </body>
        </html>';


            try {
                $maildata['messagebody_foruser'] = $html;
                $maildata['toemail'] =  'tribehelp@weremnant.org';//tribehelp@weremnant.org
                $maildata['fromemail'] = $hostname;
                $mail_send = Mail::send(array(), $maildata, function ($message) use ($maildata) {
                    $message->to($maildata['toemail'])
                        ->subject('Contact Us')
                        ->from($maildata['fromemail'], 'Remnant Tribe Network')
                        ->setBody($maildata['messagebody_foruser'], 'text/html');
                });
                    return response()->json([
                        'success' => true,
                        'message' => 'Contact details uploaded successfully.',
                    ], 200);                    
                
            } catch (Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'error. Failed',
                ]);
            }



        // return response()->json([
        //     'success' => true,
        //     'message' => 'Contact details uploaded successfully.',
        // ], 200);

    }

    public function event(Request $request)
    {

        //$input = $request->all();

        if(!isset($request->status)){
            $opt = "!=";
            $status = 2;
        }else if ($request->status == 1){
            $opt = "=";
            $status = 1;
        }else{
            $opt = "=";
            $status = 0; 
        }

        
        $event = DB::table('events')->where('status',$opt,$status)->orderBy('id','DESC')->get()->toArray();

        return response()->json([
            'success' => true,
            'data' => $event
        ], 200);

    }

    public function tribe(Request $request)
    {
        if($request->status == 1){
            $operator = "=";
            $status = "1";
        }else{
            $operator = "=";
            $status = "0";
        }

        $tribe = DB::table('tribes')->where('status',$operator,$status)->orderBy('id','DESC')->get()->toArray();

        return response()->json([
            'success' => true,
            'data' => $tribe
        ], 200);
    }

    public function tribe_privacy(Request $request)
    {
        if($request->privacy == 1){
            $operator = "=";
            $privacy = "1";
        }else{
            $operator = "=";
            $privacy = "0";
        }

        $tribe_privacy = DB::table('tribes')->select('tribe_name','privacy')->where('privacy',$operator,$privacy)->orderBy('id','DESC')->get()->toArray();

        return response()->json([
            'success' => true,
            'data' => $tribe_privacy
            //'privacy' => $tribe_privacy->privacy
        ], 200);
    }


    public function video_list(Request $request)
    {
        $link=url('/').'/storage/app/public/prayers_file/';

        $video_list = DB::table('prayers')->select('id','title','links','file','video_thumbnail')->where('file_type',3)->get()->toArray();

        $abc = array();
        //$up_video ="";

            

            foreach($video_list as $video){
                 // if(!empty($video->file)){
                    $up_video ="";
                    $up_video = $link.$video->file;
                    $thumbnail = $link.$video->video_thumbnail;

                    $abc[] = array('id'=>$video->id,'title'=>$video->title,'links'=>$video->links,'file'=>$up_video, 'video_thumbnail' =>$thumbnail );                           
                 // }
            }
         
        return response()->json([
            'data' => $abc
        ], 200);
    }

    public function video_description(Request $request)
    {
        $input = $request->all();
        $link=url('/').'/storage/app/public/prayers_file/';

        $rules = [
            'id'=>'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }

        $get_video=DB::table('prayers')->select('id','title','links','video_type','file','description','video_thumbnail')->where('id', $input['id'])->get()->toArray();

        $abc = array();
        foreach($get_video as $video){
           
               $up_video ="";
               $up_video = $link.$video->file;
               $thumbnail = $link.$video->video_thumbnail;
               $abc[] = array('id'=>$video->id,'title'=>$video->title,'description'=>$video->description,'links'=>$video->links,'video_type'=>$video->video_type,'file'=>$up_video, 'video_thumbnail' =>$thumbnail);
                       
            
       }

        return response()->json([
            'status'=>true,
            'data' => $abc
        ]);



    }


    public function video_comment_post(Request $request)
    {
        $input = $request->all();

        $rules = [
            'video_id' => 'required',
            'user_id' => 'required',
            'comment' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }
        $get_name = DB::table('users')->where('id', $request->user_id)->first();

        $comment_insert = DB::table('video_comment')->insert([
            'video_id' => $request->video_id,
            'user_name' => $get_name->full_name,
            'user_id' => $request->user_id,
            'comment' => $request->comment
        ]);
        
        if($comment_insert){
        return response()->json([
            'status'=>true,
            'message' => 'Comment uploaded successfully'
        ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'Comment did not upload'
            ]);  
        }
    }


    public function get_video_comment(Request $request)
    {
        $input = $request->all();

        $rules = [
            'video_id' => 'required',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }
        $comment_get = DB::table('video_comment')->where('video_id',$request->video_id)->get();

        if($comment_get){
            return response()->json([
                'status'=>true,
                //'message' => 'Comment update successfully'
                'data' => $comment_get
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'Faild'
            ]);  
        }

    }


   public function video_comment_edit(Request $request)
   {
        $input = $request->all();

        $rules = [
            'id' => 'required',
            'comment' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }
        
        // $comment_update = DB::table('video_comment')->where('id',$request->id)->where('comment',$request->comment)->update([
        //     'comment' => $request->comment
        // ]);
        $comment_update = DB::table('video_comment')->where('id',$request->id)->update([
            'comment' => $request->comment
        ]);

        if($comment_update){
            return response()->json([
                'status'=>true,
                'message' => 'Comment update successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'Comment did not update'
            ]);  
        }
   }



   public function video_comment_delete(Request $request)
   {
        $input = $request->all();

        $rules = [
            'id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }


        $comment_delete = DB::table('video_comment')->where('id',$request->id)->delete();

        if($comment_delete){
            return response()->json([
                'status'=>true,
                'message' => 'Comment delete successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'Comment did not delete'
            ]);  
        }


   }

   public function get_notification(Request $request)
   {

    $input = $request->all();

    $rules = [
        'id' => 'required'
    ];

    $validator = Validator::make($input, $rules);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Faild',
            'errors' => $validator->errors()
        ]);
    }

    $get_all_notification = DB::table('notification')->where('user_id',$request->id)->get()->toArray();

    if($get_all_notification){
        return response()->json([
            'status'=>true,
            'message' => 'Notification send',
            'data' => $get_all_notification
        ]);
    }else{
        return response()->json([
            'status'=>false,
            'message' => 'Did not get Id'
        ]);  
    }
    
   }

   public function notification_seen(Request $request)
   {
        $input = $request->all();

        $rules = [
            'id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }
    

        $notification_seen_update = DB::table('notification')->where('user_id',$request->id)->update([
        'notification_seen' => 1
        ]);

        if($notification_seen_update){
            return response()->json([
                'status'=>true,
                'message' => 'Notification Update',
                
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'Notification Did Not Update'
            ]);  
        }
    } 
    
    
    public function notification_delete(Request $request)
    {
        $input = $request->all();

        $rules = [
            'id' => 'required',
            'user_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }

        $delete_notification_details = DB::table('notification')->where('id',$request->id)->where('user_id',$request->user_id)->get()->toArray();
        $delete_notification = DB::table('notification')->where('id',$request->id)->where('user_id',$request->user_id)->delete();

        if($delete_notification){
            return response()->json([
                'status'=>true,
                'message' => 'Notification Delete',
                'data' => $delete_notification_details
                
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'Notification Did Not Delete'
            ]);  
        }



    }

    public function get_all_details(Request $request)
    {
        $get_all =DB::table('dashboard')->get()->toArray();

        if($get_all){
            return response()->json([
                'status'=>true,
                'message' => 'successfull',
                'data' => $get_all
                
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'faild'
            ]);  
        }
    }


    public function add_tribe(Request $request)
    {
        $input = $request->all();
        //$exp1 = explode(',',$request->user_ids);
        // return response()->json([
        //     'data' =>$exp
        // ]);
        // die;
        //$id_array[]=$request->user_ids;

        // $image_name="user-image.png";
        // $destination = storage_path('app/public/profile_pic/');
        // $allow_image_mime_type = ['image/jpeg','image/jpg','image/png'];
        // $allow_image_ext = ['jpeg','jpg','png'];

        $rules = [
            'tribe_id' => 'required',
            'user_ids' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }

        //FOR USER ARRAY INSERT TO ADMIN GROUP TABLE
        // for ($i = 0; $i < count($request->user_ids); $i++){
        //     $tribe_add = DB::table('tribe_group')->insert([
        //         'tribe_id' => $request->tribe_id,
        //         'user_id' =>$request->user_ids[$i]
        //     ]);
        // }

        for ($i = 0; $i < count($request->user_ids); $i++){
            $tribe_add = DB::table('tribe_group')->insert([
                'tribe_id' => $request->tribe_id,
                'user_id' =>$request->user_ids[$i],
                //'admin_id' =>""
            ]);
        }
        DB::table('tribe_group')->insert(['tribe_id'=>$request->tribe_id,'admin_id'=>$request->admin_id]);


        


        
        return response()->json([
            'success' => true,
            'message' => 'Successfully Add',
        ], 200);

    }


    public function add_new_tribe(Request $request)
    {
        $input = $request->all();

        $image_name="tribe-image.png";
        $destination = storage_path('app/public/tribe_image/');
        $allow_image_mime_type = ['image/jpeg','image/jpg','image/png'];
        $allow_image_ext = ['jpeg','jpg','png'];

        $rules = [
            'tribe_name' => 'required',
            'note' => 'required',
            'tribe_image' =>'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }
        

        if(!empty($request->tribe_image)){
            $exp = explode('/',$request->type);
            $image_name =time().rand(1111,9999).'.'.end($exp);

            $image_path = substr($request->tribe_image, strpos($request->tribe_image, ",")+1);

            $destination = $destination.$image_name;
           
            @file_put_contents($destination,base64_decode($image_path));
        }

        $tribe_add = DB::table('tribes')->insertGetId([
            //'id' => $request->id,
            'tribe_name' =>$request->tribe_name,
            'note' => $request->note,
            'status' => 0,
            'privacy' =>0,
            'tribe_image' => $image_name
        ]);

        if($tribe_add){
            return response()->json([
                'status'=>true,
                'message' => 'successfull',
                'data' => $tribe_add
                
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'faild'
            ]);  
        }

    }



    public function get_all_tribe(Request $request)
    {
        $link=url('/').'/storage/app/public/tribe_image/';

        $input = $request->all();

        $rules = [
            'user_id' => 'required',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }



       // $get_tribes = DB::table('tribes')->select('id','tribe_name','note','tribe_image')->where('privacy',0)->get()->toArray();

    //    $get_tribes = DB::table('tribe_group')
    //                 ->select('tribes.id','tribes.tribe_name','tribes.note','tribes.tribe_image','tribes.tribe_request','tribe_group.user_id','tribe_group.admin_id','tribe_group.tribe_id')
    //                 ->leftJoin('tribes','tribe_group.tribe_id','=','tribes.id')
    //                 ->where('tribes.tribe_request','!=',$request->user_id)
    //                 //->where('tribes.tribe_request','!=',$request->user_id)
    //                 ->where('tribe_group.user_id','!=',$request->user_id)
    //                 ->where('tribe_group.admin_id','!=',$request->user_id)
    //                 ->get()->toArray();

    //                 $get_tribes_group = DB::table('tribe_group')
    //                 ->select('tribe_group.user_id','tribe_group.admin_id','tribe_group.tribe_id')
    //                 // ->Join('tribe_group','tribe_group.tribe_id','=','tribes.id')
    //                 // ->where('tribes.tribe_request','=',$request->user_id)
    //                 // //->where('tribes.tribe_request','!=',$request->user_id)
    //                 ->where('tribe_group.user_id','!=',$request->user_id)
    //                 ->orWhere('tribe_group.admin_id','!=',$request->user_id)
    //                 ->get()->toArray(); 

        $get_tribes_by_user_id = DB::table('tribe_group')
                                ->select('tribe_id')
                                ->where('user_id',$request->user_id)
                                ->get()->toArray();


        $get_tribes_by_admin_id = DB::table('tribe_group')
                                ->select('tribe_id')
                                ->where('admin_id',$request->user_id)
                                ->get()->toArray();

                $my_array = array_merge($get_tribes_by_user_id, $get_tribes_by_admin_id);  

                $arr_tribe_id = array();
                
                if(!empty($my_array)){
                    
                    $i = 1;
                    $cnt = count($my_array);

                    foreach($my_array as $val){
                        
                        $i++;
                        $arr_tribe_id[] = $val->tribe_id;
                    }
                    
                    $result = DB::table('tribes')
                    ->select('*')
                    ->whereNotIn('id', $arr_tribe_id)
                    ->get()->toArray();   

                } else {

                    $result = DB::table('tribes')
                    ->select('*')
                    ->get()->toArray(); 

                }

                //echo $strids; die();
                                
                       
                
                //dd($result);
                 //

                    // return response()->json([
                    //     'data' => $my_array
                    // ], 200);     

                    // die;

        

            $abc = array();
    
            foreach($result as $tribe){
                    $tribes_img ="";
                    $tribes_img = $link.$tribe->tribe_image;

                    $abc[] = array('id'=>$tribe->id,'tribe_name'=>$tribe->tribe_name,'note'=>$tribe->note,'tribe_image'=>$tribes_img);
            }
         
        return response()->json([
            'data' => $abc
        ], 200);
    }


    public function get_details_user_tribe(Request $request)
    {
        $link=url('/').'/storage/app/public/tribe_image/';
        $link1=url('/').'/storage/app/public/profile_pic/';

        $input = $request->all();

        $image_name="tribe-image.png";
        $destination = storage_path('app/public/tribe_image/');
        $allow_image_mime_type = ['image/jpeg','image/jpg','image/png'];
        $allow_image_ext = ['jpeg','jpg','png'];

        $rules = [
            'tribe_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }


        $get_tribe_details = DB::table('tribes')->select('id','tribe_name','tribe_image','status','note')->where('id',$request->tribe_id)->get();
        $tribe_details = array();
        $opt = [];

                foreach($get_tribe_details as $tribe){
                    $opt['status'] = true;
                    $tribes_img ="";
                    $tribes_img = $link.$tribe->tribe_image;
                    $tribe_details[] = array('id'=>$tribe->id,'tribe_name'=>$tribe->tribe_name,'status'=>$tribe->status,'note'=>$tribe->note,'tribe_image'=>$tribes_img);                           
                    
                    $opt['tribe'] = $tribe_details;

                    $get_admin_details = DB::table('tribe_group')->where('tribe_id',$tribe->id)->whereNotNull('admin_id',)->where('request_status',0)->select(
                                        "users.id",
                                        DB::raw("CONCAT('".$link1."','',users.profile_image) as image"),
                                        "users.mobile_no",
                                        "users.full_name"
                                    )->Join("users", "users.id", "=", "tribe_group.admin_id")->get()->toArray();
                      

                    $opt['admin'] = $get_admin_details;

                    $get_user_details = DB::table('tribe_group')->where('tribe_id',$tribe->id)->whereNotNull('user_id',)->where('request_status',0)->select(
                        "users.id",
                         DB::raw("CONCAT('".$link1."','',users.profile_image) as pimage"),
                        "users.mobile_no",
                        "users.full_name"
                    )->Join("users", "users.id", "=", "tribe_group.user_id")->get()->toArray();

                    $opt['users'] = $get_user_details;

                    $get_approval_user_details = DB::table('tribe_group')->where('tribe_id',$tribe->id)->where('request_status',1)->select(
                        "users.id",
                         DB::raw("CONCAT('".$link1."','',users.profile_image) as pimage"),
                        "users.mobile_no",
                        "users.full_name"
                    )->Join("users", "users.id", "=", "tribe_group.user_id")->get()->toArray();

                    $opt['pending'] = $get_approval_user_details;

                }

                
       // dd($opt);
            // $admin_details = array();

            //     foreach($get_admin_details as $admin){
            //         $admin_img ="";
            //         $admin_img = $link1.$admin->profile_image;
            //         $admin_details[] = array('id'=>$admin->id,'full_name'=>$admin->full_name,'mobile_no'=>$admin->mobile_no,'profile_image'=>$admin_img);                           
            //         }
      

        
            // $user_details = array();

            //     foreach($get_user_details as $user){
            //         $user_img ="";
            //         $user_img = $link1.$user->profile_image;
            //         $user_details[] = array('id'=>$user->id,'full_name'=>$user->full_name,'mobile_no'=>$user->mobile_no,'profile_image'=>$user_img);                           
            //         }
                
        return response()->json([
            'data' => $opt
        ]);

    }


    public function user_in_tribe_group(Request $request)
    {
        $link=url('/').'/storage/app/public/tribe_image/';
        $input = $request->all();

        $rules = [
            'user_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }

        $find_user = DB::table('tribe_group')->where('tribe_group.user_id',$request->user_id)->where('request_status',0)
        ->select(
        "tribes.id",
        "tribes.tribe_name",
        "tribes.note",
        DB::raw("CONCAT('".$link."','',tribes.tribe_image) as tribe_image")
        // "tribes.tribe_image"
        )->Join("tribes","tribes.id","=","tribe_group.tribe_id")->get();

        $abc['users']= $find_user;

        $find_admin = DB::table('tribe_group')->where('tribe_group.admin_id',$request->user_id)->where('request_status',0)
        ->select(
        "tribes.id",
        "tribes.tribe_name",
        "tribes.note",
        DB::raw("CONCAT('".$link."','',tribes.tribe_image) as tribe_image")
        // "tribes.tribe_image"
        )->Join("tribes","tribes.id","=","tribe_group.tribe_id")->get();
        $abc['admin']= $find_admin;
       
        
        return response()->json([
            'data' => $abc
        ]);

    }


    public function user_not_in_tribe_group(Request $request)
    {       
        $input = $request->all();

        $rules = [
            'user_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }

        $find_user = DB::table('tribe_group')->select('tribe_id')->where('user_id',$request->user_id)->orWhere('admin_id',$request->user_id)->distinct()->get()->toArray();


        return response()->json([
            'data' => $find_user
        ]); die;
        // $abc['users']= $find_user;

        // $find_admin = DB::table('tribe_group')->select('tribe_id')->where('admin_id',$request->user_id)->get()->toArray();
        
        // //$abs['admin']= $find_admin; 

        // array_push($abc['users'],$find_admin);
        // //dd( $abc['users']);
        // $details = array(); 

        // $other_user = DB::table('tribes')->select('id')->where('id', $find_user[]->tribe_id)->get();
        // return response()->json([
        //     'data' => $other_user
        // ]); die;


        $in = array();
        $notin = array();
        
        for($i = 0; $i < count($find_user); $i++){

        $details = DB::table('tribes')->select('id','tribe_name')->where('id', $find_user[$i]->tribe_id)->first();

        if(!empty($details)){
            $in[]= array('id'=>$details->id,'tribe_name'=> $details->tribe_name);
        }else{
            $notin[]=array('id'=>$find_user[$i]->tribe_id);
        }

        }

       

        return response()->json([
            'data' => $notin
        ]);

    }



    public function delete_user_from_group(Request $request)
    {
        $input = $request->all();

        $rules = [
            'user_id' => 'required',
            'tribe_id' => 'required',
            'admin_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }

        $delete = DB::table('tribe_group')->where('tribe_id',$request->tribe_id)->where('user_id',$request->user_id)->delete();

        if($delete){
            return response()->json([
                'status'=>true,
                'message' => 'User Delete',
                
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'User Did Not Delete'
            ]);  
        }
    }


    public function update_admin_from_group(Request $request)
    {
        $input = $request->all();

        $rules = [
            'user_id' => 'required',
            'tribe_id' => 'required',
            'admin_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }

        $get = DB::table('tribe_group')->select('admin_id')->where('user_id',$request->user_id)->where('tribe_id',$request->tribe_id)->get();

        // return response()->json([
        //     'staus' => true,
        //     'data' => $get
        // ]); die;

        if(!empty($get)){
            $update = DB::table('tribe_group')->where('user_id',$request->user_id)->where('tribe_id',$request->tribe_id)->update(['admin_id' =>$request->user_id, 'user_id'=>null]);
        }else{
            // $update_admin = DB::table('tribe_group')->where('admin_id',$request->user_id)->update(['admin_id' =>$request->user_id]);
        }

        return response()->json([
            'staus' => true
        ]);

    }


    public function update_tribe_details(Request $request)
    {
        $input = $request->all();

        $rules = [
            'note' => 'required',
            'tribe_id' => 'required',
            'admin_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }

        $note_update = DB::table('tribes')->where('id',$request->tribe_id)->update(['note'=> $request->note]);

        if($note_update){
            return response()->json([
                'status'=>true,
                'message' => 'Update successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'Did not update'
            ]);  
        }

    }


    public function tribe_status(Request $request)
    {
        $input = $request->all();

        $rules = [
            'tribe_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }

        $status = DB::table('tribes')->where('id',$request->tribe_id)->update(['status'=>1]);

        if($status){
            return response()->json([
                'status'=>true,
                'message' => 'Update successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'Did not update'
            ]);  
        }
    }


    public function inactive_to_active_status(Request $request)
    {
        $input = $request->all();

        $rules = [
            'tribe_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }
        $status1 = DB::table('tribes')->where('id',$request->tribe_id)->update(['status'=>0]);

        if($status1){
            return response()->json([
                'status'=>true,
                'message' => 'Update successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'Did not update'
            ]);  
        }
    }

    public function delete_tribe(Request $request)
    {
        $input = $request->all();

        $rules = [
            'tribe_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }

        $delete = DB::table('tribes')->where('id',$request->tribe_id)->delete();

        
        if($delete){
            return response()->json([
                'status'=>true,
                'message' => 'Successfully Delete'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'Did not Delete'
            ]);  
        }
    }

    public function update_tribe_name(Request $request)
    {
        $input = $request->all();

        $rules = [
            'tribe_name' => 'required',
            'tribe_id' => 'required',
            'admin_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }

        $note_update = DB::table('tribes')->where('id',$request->tribe_id)->update(['tribe_name'=> $request->tribe_name]);

        if($note_update){
            return response()->json([
                'status'=>true,
                'message' => 'Update successfully'
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'Did not update'
            ]);  
        }

    }

    public function tribe_change_image(Request $request)
    {
        $input = $request->all();

        $image_name="tribe-image.png";
        $destination = storage_path('app/public/tribe_image/');
        $allow_image_mime_type = ['image/jpeg','image/jpg','image/png'];
        $allow_image_ext = ['jpeg','jpg','png'];

        $rules = [
            'tribe_id' => 'required',
            'tribe_image' =>'required',
            'admin_id' =>'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }
        

        if(!empty($request->tribe_image)){
            $exp = explode('/',$request->type);
            $image_name =time().rand(1111,9999).'.'.end($exp);

            $image_path = substr($request->tribe_image, strpos($request->tribe_image, ",")+1);

            $destination = $destination.$image_name;
           
            @file_put_contents($destination,base64_decode($image_path));
        }

        $tribe_img_update = DB::table('tribes')->where('id',$request->tribe_id)->update([
            'tribe_image' => $image_name
        ]);

        if($tribe_img_update){
            return response()->json([
                'status'=>false,
                'message' => 'successfull',
                //'data' => $tribe_add
                
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'faild'
            ]);  
        }

    }


    public function request_pending_tribe_group(Request $request)
    {
        $input = $request->all();

        $rules = [
            'tribe_id' => 'required',
            'user_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }
        $get_data = DB::table('tribe_group')->where('user_id',$request->user_id)->where('tribe_id',$request->tribe_id)->get()->toArray();

        if(!empty($get_data)){
            return response()->json([
                'status'=>true,
                'message' => 'You are already Requested'
                
            ]);
        }else{

        $request_tribe = DB::table('tribe_group')->insert([
            'tribe_id' =>$request->tribe_id,
            'user_id'=>$request->user_id,
            'request_status'=>1
        ]);
            return response()->json([
                'status'=>true,
                'message' => 'Request Successfully add',
                
            ]);
        }

    }


    public function request_approve_tribe_group(Request $request)
    {
        $input = $request->all();

        $rules = [
            'tribe_id' => 'required',
            'user_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }

        $request_tribe_approve = DB::table('tribe_group')->where('tribe_id',$request->tribe_id)->where('user_id',$request->user_id)->update([
            'request_status'=>0
        ]);

        if($request_tribe_approve){
            return response()->json([
                'status'=>true,
                'message' => 'Update Successfully ',
                
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'message' => 'Update Faild'
            ]);  
        }

        
    }


    public function get_user_details_using_mobile_no(Request $request)
    {
        
        $link=url('/').'/storage/app/public/profile_pic/';
    
        $valid = array();
        $invalid = array();
        
        for($i = 0; $i < count($request->mobile_no); $i++){

            $details = DB::table('users')->select('id','full_name','profile_image','mobile_no')->where('user_type',3)->where('mobile_no', $request->mobile_no[$i])->first();

            if(!empty($details)){
                $valid[]= $details->id;
            }else{
                $invalid[]=$request->mobile_no[$i];
            }
        }

        //dd($valid);

        // return response()->json([
        //     $valid
        // ]); die;
        
        $valid1 = array();
        $invalid1 = array();


            foreach($valid as $abc){
                //dd($abc);
                $get = DB::table('tribe_group')->select('user_id')->where('user_id',$abc)->where('tribe_id',$request->tribe_id)->orWhere('admin_id',$abc)->get()->toArray();
               //dd($get); 

               
                if(empty($get))
                {
                    $valid1[] = $abc;
                    // if(!in_array($abc,$valid1)) {
                    //     $get11 = DB::table('tribe_group')->select('admin_id')->where('admin_id',$abc)->where('tribe_id',$request->tribe_id)->get()->toArray();

                    
                    //     if(empty($get11))
                    //     {
                        
                    //         $valid1[] = $abc;
                        
                    //     }
                    // }
                }

                //dd($valid1);

                
            }
            
           // dd($valid1); 



            //   return response()->json([
            //     $valid1
            //     ]); die;

            $u_details = array();
            $u_details_not = array();

            // foreach($valid as $mno){
            //     $details_user = DB::table('users')->select('id','full_name','profile_image','mobile_no')->where('user_type',3)->where('user_id', $valid1[$i])->first();

            //     if(!empty($mno)){
            //         $qwe[] = $mno;
                    
            //     }
            // }dd($qwe);



            for($i = 0; $i < count($valid1); $i++){

            $details_user = DB::table('users')->select('id','full_name','profile_image','mobile_no')->where('user_type',3)->where('id', $valid1[$i])->first();

                //dd($details_user);

            if(!empty($details_user)){
                $u_details[]= array('id'=>$details_user->id,'full_name'=> $details_user->full_name,'mobile_no'=>$details_user->mobile_no,'profile_image'=>$link.$details_user->profile_image);
            }else{
                $u_details_not[]=array($request->mobile_no[$i]);
            }
        }

          return response()->json([
                'data' => $u_details
                ]); 
            
    }


    public function add_user_tribe_group(Request $request)
    {
        $input = $request->all();
        
        $rules = [
            'tribe_id' => 'required',
            'user_id' => 'required',
            'admin_id' => 'required'
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Faild',
                'errors' => $validator->errors()
            ]);
        }

        for ($i = 0; $i < count($request->user_id); $i++){
            $tribe_add = DB::table('tribe_group')->insert([
                'tribe_id' => $request->tribe_id,
                'user_id' =>$request->user_id[$i],
                //'admin_id' =>""
            ]);
        }
       
        return response()->json([
            'success' => true,
            'message' => 'Successfully Add User in Tribe Group ',
        ], 200);

    }


    public function tribe_chat(Request $request)
    {
        // $input = $request->all();
        
        // $rules = [
        //     'tribe_id' => 'required',
        //     'user_id' => 'required',
        //     'message_type' => 'required',
        // ];

        // $validator = Validator::make($input, $rules);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Faild',
        //         'errors' => $validator->errors()
        //     ]);
        // }




       
    }






}

