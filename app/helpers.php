<?php 
   
    function get_modules_details($id)
    {
        $data = DB::table('module_details')->where('module_id',$id)->orderBy('id','ASC')->get();

        if(!empty($data)){
            return $data;
        }else{
            return '';
        }
    }


    function get_role_permission($role_id)
    {
        $role_perssion = DB::table('roles')->where('id',$role_id)->select('permission')->first();

        if(isset($role_perssion->permission)){
            return $role_perssion->permission;
        }else{
            return '';
        }
    }






?>