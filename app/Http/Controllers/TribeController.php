<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class TribeController extends Controller
{
    public function index()
    {
        $tribe_list = DB::table('tribes')->orderBy('created_at','DESC')->get();
        return view('tribe.tribe_list',compact('tribe_list'));
    }

    public function create()
    {
        return view('tribe.tribe_create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'tribe_name' => 'required|string|max:255'
        ]);

        $insert = DB::table('tribes')->insert([
            'tribe_name' => $request->tribe_name,
            'note' => $request->note
        ]);

        if($insert){
            return redirect('admin/tribe-list')->with('success','New Tribe has been created');
        }else{
            return redirect()->back()->with('error','Something Wents Wrong,Please try again later...');
        }

    }



    public function edit(Request $request, $id)
    {

        $tribe_details = DB::table('tribes')->where('id',$id)->first();
        return view('tribe.tribe_edit',compact('tribe_details'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'tribe_name' => 'required|string|max:255',
            'tribe_id' => 'required|numeric'
        ]);

        $update = DB::table('tribes')->where('id',$request->tribe_id)->update([
            'tribe_name' => $request->tribe_name,
            'note' => $request->note,
            'privacy' => $request->privacy
        ]);

        if($update){
            return redirect('admin/tribe-list')->with('success','Tribe Updated Successfully');
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


    public function status_update(Request $request)
    {
        $update = DB::table('tribes')->where('id',$request->id)->update([
            'status' =>$request->update
        ]);
     
        if($update){
            return response()->json(['status'=>1]);
        }else{
            return response()->json(['status'=>0]);
        }
    }

    public function subscribe_tribe(Request $request)
    {
        $input = $request->all();
        $ids = '';

        $request->validate([
        'user_id' => 'required|numeric',
        'subscribe.*' => 'required|numeric'
        ]);

        if(!empty($input['subscribe'])){

            for($i = 0; $i < count($input['subscribe']); $i++){
                $ids.=$input['subscribe'][$i].',';
            }

        }else{
            return redirect()->back()->with('error','Please select tribe from tribe list');
        }

        $ids = rtrim($ids, ',');

        $find_data = DB::table('subscribe_tribes')->where('user_id',$input['user_id'])->first();

        if(isset($find_data->id)){

            $update = DB::table('subscribe_tribes')->where('user_id',$input['user_id'])->update([
                'tribes_id' =>  $ids
            ]);

            if($update){
                return redirect()->back()->with('success','Tribe subscribe list has been updated');
            }else{
                return redirect()->back()->with('error','Some error occured.Try again later...');
            }

        }else{
            $create = DB::table('subscribe_tribes')->insert([
                'user_id' => $input['user_id'],
                'tribes_id' =>  $ids
            ]);

            if($create){
                return redirect()->back()->with('success','Tribe subscribe list has been updated');
            }else{
                return redirect()->back()->with('error','Some error occured.Try again later...');
            }
        }

       
    }

    public function fetch_subscribe_list(Request $request)
    {
        $html = '';
        $get_data = DB::table('subscribe_tribes')->where('user_id',$request->id)->first();
        $tribes = DB::table('tribes')->where('status',0)->where('privacy',0)->orderBy('tribe_name','ASC')->get();

        if(!empty($get_data)){
            $exp_tribe_id = explode(',',$get_data->tribes_id);
            foreach ($tribes as $tribe) {
                if(in_array($tribe->id,$exp_tribe_id)){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }

                $html.='<div class="col-md-3">
                        <input type="checkbox" name="subscribe[]"'.$checked.' value="'.$tribe->id.'">&nbsp;'.$tribe->tribe_name.'
                        </div>'; 
            }

        }else{
            foreach ($tribes as $tribe) {
                $html.='<div class="col-md-3">
                        <input type="checkbox" name="subscribe[]" value="'.$tribe->id.'">&nbsp;'.$tribe->tribe_name.'
                        </div>'; 
            }
        }

        return $html;
    }
}
