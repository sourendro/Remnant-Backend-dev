<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Roles::orderBy('created_at','DESC')->get();
        return view('roles.roles_list',compact('roles'));
    }

    public function create()
    {
        
        $get_modules = DB::table('modules')->orderBy('modules.id','ASC')->get();

        return view('roles.role_create',compact('get_modules'));
    }

    public function store(Request $request)
    {
        $module_id_array = [];
        $module_ids = '';
        $permission_id = '';
        $input = $request->all();

        $request->validate([
            'role_name'=> 'required|string|max:255',
        ],
        [
            'role_name.required' => 'Role name is required',
            'role_name.string' => 'Role name is contain only alphabet',
            'role_name.max' => 'Role name is must be less than 255 character',

        ]);

        if(isset($input['permissions'])){

            if(count($input['permissions']) > 0){

                for($j = 0; $j < count($input['permissions']); $j++){

                    $get_module_id = DB::table('module_details')->select('module_id')->where('id',$input['permissions'][$j])->first();

                    if(!in_array($get_module_id->module_id, $module_id_array))
                    {
                        array_push($module_id_array,$get_module_id->module_id);
                        $module_ids.= $get_module_id->module_id.',';
                    }

                    $permission_id.= $input['permissions'][$j].',';

                
                }

                $permission_id = rtrim($permission_id,',');
                $module_ids = rtrim($module_ids,',');

                

                $roles = Roles::create([
                    'role_name'=>$request->role_name,
                    'note' => $request->note,
                    'permission' => $permission_id,
                    'module_id'=>$module_ids
                ]);

                

                return redirect('admin/roles')->with('success','Role Successfully Created');
            
            }else{
                return redirect()->back()->with('error','Please Select Any Modules');
            }
        }else{
            return redirect()->back()->with('error','Please Select Any Modules');
        }
    }


    public function edit(Request $request, $id)
    {
        $roles_details = Roles::find($id);
        $get_modules = DB::table('modules')->orderBy('modules.id','ASC')->get();

       return view('roles.role_edit',compact('roles_details','get_modules'));
    }

    public function update(Request $request)
    {
        $permission_ids = '';
        $input = $request->all();
        $module_id_array = [];
        $module_ids = '';

        $request->validate([
            'role_name'=> 'required|string|max:255',
        ],
        [
            'role_name.required' => 'Role name is required',
            'role_name.string' => 'Role name is contain only alphabet',
            'role_name.max' => 'Role name is must be less than 255 character',

        ]);

        // echo "<pre>";
        // print_r($request->all());
        // die;

        if(isset($input['permissions'])){

            if(count($input['permissions']) > 0){

                for($j = 0; $j < count($input['permissions']); $j++){

                    $get_module_id = DB::table('module_details')->select('module_id')->where('id',$input['permissions'][$j])->first();

                    if(!in_array($get_module_id->module_id, $module_id_array))
                    {
                        array_push($module_id_array,$get_module_id->module_id);
                        $module_ids.= $get_module_id->module_id.',';
                    }
                    
                    $permission_ids.= $input['permissions'][$j].',';
                    
                }

                $permission_ids = rtrim($permission_ids,',');
                $module_ids = rtrim($module_ids,',');

                $roles = Roles::where('id',$request->role_id)->update([
                    'role_name'=>$request->role_name,
                    'note' => $request->note,
                    'permission' => $permission_ids,
                    'module_id'=>$module_ids
                ]);

                return redirect('admin/roles')->with('success','Role Successfully Updated');
            
            }else{
                return redirect()->back()->with('error','Please Select Any Modules');
            }
        }else{
            return redirect()->back()->with('error','Please Select Any Modules');
        }

        
    }
}
