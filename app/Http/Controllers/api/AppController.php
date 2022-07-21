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

        $video_list = DB::table('prayers')->select('id','title','links','file','video_thumbnail')->get()->toArray();

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

        $get_video=DB::table('prayers')->select('id','title','links','file','description','video_thumbnail')->where('id', $input['id'])->get()->toArray();

        $abc = array();
        foreach($get_video as $video){
           
               $up_video ="";
               $up_video = $link.$video->file;
               $thumbnail = $link.$video->video_thumbnail;
               $abc[] = array('id'=>$video->id,'title'=>$video->title,'links'=>$video->links,'file'=>$up_video, 'video_thumbnail' =>$thumbnail);
                       
            
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

        $comment_insert = DB::table('video_comment')->insert([
            'video_id' => $request->video_id,
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



}

