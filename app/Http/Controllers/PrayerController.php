<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class PrayerController extends Controller
{
    public function index()
    {
        $prayers_list = DB::table('prayers')->orderBy('created_at','DESC')->get();
        return view('prayer.prayer_view',compact('prayers_list'));
    }


    public function create()
    {
        return view('prayer.prayer_create');
    }


    public function store(Request $request)
    {
        // print_r($request->all());
        // die;


        $destination = storage_path('app/public/prayers_file');
        $file_name = '';

        $request->validate([
            'title' => 'required|string',
            'description' => 'required',
            'file_type' => 'required',
        ]);

        if($request->file_type == 2){

            
            $allow_image_mime_type = ['image/jpeg','image/jpg','image/png'];
            $allow_image_ext = ['jpeg','jpg','png'];
            
            $get_image   = $request->file('image_file');
            $image_mime_type  = $get_image->getMimeType();
            $image_ext   = $get_image->getClientOriginalExtension();

            if (in_array($image_mime_type, $allow_image_mime_type)) {

                if(in_array($image_ext, $allow_image_ext)){

                    $file_name = time().rand(1111,9999).".".$image_ext;

                    $get_image->move($destination,$file_name);

                }
                
            }

        }else if ($request->file_type == 1){

            $allow_audio_mime_type = ['audio/mpeg'];
            $allow_audio_ext = ['mp3'];
            $get_audio   = $request->file('audio_file');
            $audio_mime_type  = $get_audio->getMimeType();
            $audio_ext   = $get_audio->getClientOriginalExtension();
         

            if (in_array($audio_mime_type, $allow_audio_mime_type)) {

                if(in_array($audio_ext, $allow_audio_ext)){

                    $file_name = time().rand(1111,9999).".".$audio_ext;

                    $get_audio->move($destination,$file_name);

                }
                
            }
        }else if ($request->file_type == 3){

            if($request->video_type == 3){

                $allow_video_mime_type = ['video/mp4','application/x-mpegURL','video/MP2T','video/3gpp'];
                $allow_video_ext = ['mp4','jpg','png'];
                
                $get_video   = $request->file('video_file');
                $video_mime_type  = $get_video->getMimeType();
                $video_ext   = $get_video->getClientOriginalExtension();


                if (in_array($video_mime_type, $allow_video_mime_type)) {

                    if(in_array($video_ext, $allow_video_ext)){

                        $file_name = time().rand(1111,9999).".".$video_ext;

                        $get_video->move($destination,$file_name);

                    }
                    
                }
            }
            
        }
//FOR VIDEO THUMBNAIL
        $video_thumbnail="";
        if(!empty($request->file('video_thumbnail'))){
        
        $allow_image_mime_type = ['image/jpeg','image/jpg','image/png'];
        $allow_image_ext = ['jpeg','jpg','png'];
    
        $get_image   = $request->file('video_thumbnail');
        $image_mime_type  = $get_image->getMimeType();
        $image_ext   = $get_image->getClientOriginalExtension();

        if (in_array($image_mime_type, $allow_image_mime_type)) {

            if(in_array($image_ext, $allow_image_ext)){

                $video_thumbnail = time().rand(1111,9999).".".$image_ext;

                $get_image->move($destination,$video_thumbnail);

            }
            
        }
    }



        // if($file_name == '')
        // {
        //     return redirect()->back()->with('error','Uploaded file type are not allowed');
        //     die;
        // }

        $insert = DB::table('prayers')->insert([
            'created_by' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'file_type' => $request->file_type,
            'video_type' => $request->video_type,
            'links' => $request->links,
            'file' => $file_name,
            'video_thumbnail' =>$video_thumbnail

        ]);
       
        if($insert){
            return redirect('admin/prayer')->with('success','New Prayers has been created');
        }else{
            return redirect()->back()->with('error','Something Wents Wrong,Please try again later...');
        }

    }



    public function edit(Request $request, $id)
    {   
        $prayers_details = DB::table('prayers')->where('id',$id)->first();

        return view('prayer.prayer_edit',compact('prayers_details'));
    }

    public function update(Request $request)
    {

        $video_type = '';
        $destination = storage_path('app/public/prayers_file');
        $file_name = '';
        $request->validate([
            'title' => 'required|string|max:30',
            'description' => 'required',
            'file_type' => 'required',
        ]);



        $get_file_info =  DB::table('prayers')->where('id',$request->prayers_id)->first();

        if($request->file_type == 2){

            $video_type = 0;
            
            if(!empty($_FILES['image_file']['name'])){

                $allow_image_mime_type = ['image/jpeg','image/jpg','image/png'];
                $allow_image_ext = ['jpeg','jpg','png'];
                
                $get_image   = $request->file('image_file');
                $image_mime_type  = $get_image->getMimeType();
                $image_ext   = $get_image->getClientOriginalExtension();

                if (in_array($image_mime_type, $allow_image_mime_type)) {

                    if(in_array($image_ext, $allow_image_ext)){

                        $file_name = time().rand(1111,9999).".".$image_ext;

                        $get_image->move($destination,$file_name);
                        unlink($destination.'/'.$get_file_info->file);

                    }
                    
                }
            }
            
        }else if ($request->file_type == 1){

            $video_type = 0;
            if(!empty($_FILES['audio_file']['name'])){

                $allow_audio_mime_type = ['audio/mpeg'];
                $allow_audio_ext = ['mp3'];
                $get_audio   = $request->file('audio_file');
                $audio_mime_type  = $get_audio->getMimeType();
                $audio_ext   = $get_audio->getClientOriginalExtension();
            

                if (in_array($audio_mime_type, $allow_audio_mime_type)) {

                    if(in_array($audio_ext, $allow_audio_ext)){

                        $file_name = time().rand(1111,9999).".".$audio_ext;

                        $get_audio->move($destination,$file_name);
                        unlink($destination.'/'.$get_file_info->file);

                    }
                    
                }
            }
        }else if ($request->file_type == 3){

            $video_type = $request->video_type;
            if($request->video_type == 3){

                if(!empty($_FILES['video_file']['name'])){

                    $allow_video_mime_type = ['video/mp4','application/x-mpegURL','video/MP2T','video/3gpp'];
                    $allow_video_ext = ['mp4','jpg','png'];
                    
                    $get_video   = $request->file('video_file');
                    $video_mime_type  = $get_video->getMimeType();
                    $video_ext   = $get_video->getClientOriginalExtension();


                    if (in_array($video_mime_type, $allow_video_mime_type)) {

                        if(in_array($video_ext, $allow_video_ext)){

                            $file_name = time().rand(1111,9999).".".$video_ext;

                            $get_video->move($destination,$file_name);

                            unlink($destination.'/'.$get_file_info->file);

                        }
                        
                    }
                }
            }
        }



        $update_array = [
            'created_by' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'file_type' => $request->file_type,
            'video_type' => $video_type,
            'links' => $request->video_file_link,
        ];


        if($file_name != '')
        {
            $update_array['file'] = $file_name;
        }

        $update = DB::table('prayers')->where('id',$request->prayers_id)->update($update_array);

        if($update){
            return redirect('admin/prayer')->with('success','Prayers Updated Successfully');
        }else{
            return redirect()->back()->with('error','Something Wents Wrong,Please try again later...');
        }
    }

    public function delete(Request $request, $id)
    {
        $delete = DB::table('tribes')->where('id',$id)->delete();

        if($delete){
            return redirect('admin/tribe-list')->with('success','Tribe Deleted Successfully');
        }else{
            return redirect('admin/tribe-list')->with('error','Something Wents Wrong,Please try again later...');
        }
    }
}
