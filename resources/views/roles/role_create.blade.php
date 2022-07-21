@extends('layouts.admin')

@section('title','New Role')

@section('content')
<div class="container-fluid">
    <div class="main-page-content">
        <div id="firstTab" class="tabcontent">
            <h4>New Role</h4>
            @include('flash-message')
        <form  method="post" action="{{ url('admin/role-store')}}" autocomplete="off">

        @csrf
        <div class="row">
            <div class="col-md-6">
                <label class="label">Role Name</label>
                <input type="text" name="role_name" id="role_name" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="label">Note</label>
               <textarea name="note" id="note" cols="2" rows="2" class="form-control"></textarea>
            </div>
        </div>
       
        <div class="row mt-2">
            <h6>Role permissions</h6>


            @foreach($get_modules as $module)
            <div class="col-md-3">
                
                <div class="permissions-modules-item mt-1 mb-4">
                   
                    <div class="form-check">
                        <label class="permissions-modules-item-title">
                            <input type="checkbox" class="permissions-modules-item-title-checkbox form-check-input all"><b>{{ $module->module_name}}</b></label>

                           
                    </div> 

                    @php
                        $details = get_modules_details($module->id);
        
                    @endphp

                    @foreach($details as $data)
                    <div class="permissions-modules-item-checkbox checkbox">
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $data->id}}" id="permission-read-announcements" class="form-check-input sub"> <label for="permission-read-announcements" class="form-check-label">{{ $data->text}}</label>
                        </div>
                    </div> 
                    @endforeach
                   
                </div>
            </div>
            @endforeach
            
            

            
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
    </div>
    </div>
</div>
@endsection