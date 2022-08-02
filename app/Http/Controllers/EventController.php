<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class EventController extends Controller
{
    public function index(){
        $event_list = DB::table('events')->orderBy('id','DESC')->get();
        return view('events.events_view',compact('event_list'));
        //return view('events.events_view');
    }


    public function create()
    {
        return view('events.create_event');
    }


    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'privacy' =>'required|numeric'
        ]);

        $insert = DB::table('events')->insertGetId([
            'event_name' => $request->event_name,
            //'description' => $request->description,
            'description' => strip_tags($request->description),
            'privacy' => $request->privacy,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time
        ]);
        
        //$last_event_id = DB::getPdo()->lastInsertId();

        //FOR NOTIFICATION 
        $get_all_user = DB::table('users')->select('id')->where('user_type',3)->get()->toArray();
       
        for ($i = 0; $i < count($get_all_user); $i++){
            $notification = DB::table('notification')->insert([
                'body' => 'New Event Created ',
                'notification_type' => 'event',
                'user_id' => $get_all_user[$i]->id,
                'notification_event_id' =>$insert, //GET EVENT ID BECAOUSE IN EVENT INSERT I WRITE insertGetId().
                'notification_title' =>$request->event_name,
                'notification_description' => $request->description
            ]);
        }

        //die;


        if($insert){
            return redirect('admin/events')->with('success','New Event has been created');
        }else{
            return redirect()->back()->with('error','Something Wents Wrong,Please try again later...');
        }

    }

    public function status_update(Request $request)
    {
        $update = DB::table('events')->where('id',$request->id)->update([
            'status' =>$request->update
        ]);
     
        if($update){
            return response()->json(['status'=>1]);
        }else{
            return response()->json(['status'=>0]);
        }
    }

    public function edit(Request $request, $id)
    {

        $event_details = DB::table('events')->where('id',$id)->first();
        return view('events.event_edit',compact('event_details'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_id' => 'required|numeric'
        ]);

        $update = DB::table('events')->where('id',$request->event_id)->update([
            'event_name' => $request->event_name,
            'description' => $request->description,
            'privacy' => $request->privacy,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time
        ]);

        if($update){
            return redirect('admin/events')->with('success','Event Updated Successfully');
        }else{
            return redirect()->back()->with('error','Something Wents Wrong,Please try again later...');
        }
    }

    public function delete(Request $request, $id)
    {
        $delete = DB::table('events')->where('id',$id)->delete();

        if($delete){
            return redirect('admin/events')->with('success','Event Deleted Successfully');
        }else{
            return redirect('admin/events')->with('error','Something Wents Wrong,Please try again later...');
        }
    }



}

