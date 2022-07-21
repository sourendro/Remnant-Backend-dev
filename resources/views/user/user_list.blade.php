@extends('layouts.admin')

@section('title','User Management')

@section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <h4>Admin User list <a href="{{ url('admin/add-user')}}" style="float: right" class="btn btn-dark">Add New User</a></h4>
                @include('flash-message')
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <th>S.No</th>
                            <th>Name</th>
                            {{-- <th>User Name</th> --}}
                            <th>Email</th>
                            <th>Mobile No.</th>
                            <th>Gender</th>
                            <th>Role</th>
                            {{-- <th>Last Login</th> --}}
                            <th>Register At</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @if(count($users) > 0)
                                @foreach ($users as $user_data)
                                @php
                                    $gender = $user_data->gender == 1 ? 'Male' : ($user_data->gender == 2 ? 'Female' : 'Transgender');
                                    $status = $user_data->status == 0 ? 'Active' : 'Inactive';
                                @endphp
                                    <tr id="tr_<?=$user_data->id;?>">
                                        <input type="hidden" class="user" value="{{ $user_data->id}}">
                                        <input type="hidden" class="gender" value="{{ $user_data->gender }}">
                                        <input type="hidden" class="status" value="{{ $user_data->status }}"> 
                                        <input type="hidden" class="role" value="{{ $user_data->role }}">
                                        <input type="hidden" class="mob_no" value="{{ $user_data->mobile_no }}">
                                        <input type="hidden" class="cun_code" value="{{ $user_data->country_code }}"> 
                                        <td>{{ $sl++ }}</td>
                                        <td class="name">{{ $user_data->full_name}}</td>
                                        {{-- <td class="userName">{{ $user_data->user_name}}</td> --}}
                                        <td class="email">{{ $user_data->email}}</td>
                                        <td class="mobile_no">{{ $user_data->country_code}} {{ $user_data->mobile_no}}</td>
                                        <td class="genderText">{{ $gender}}</td>
                                        <td class="roleText">{{ $user_data->role_name }}</td>
                                        {{-- <td>{{ date('d-m-Y h:s',strtotime($user_data->last_login_at))}}</td> --}}
                                        <td>{{ date('d-m-Y h:s',strtotime($user_data->created_at))}}</td>
                                        <td>
                                            <input type="checkbox" style="cursor: pointer" class="status_check" <?= $user_data->status == 0 ? 'checked' : ''?> title="Click for active inactive status" >&nbsp;&nbsp;
                                           
                                            <i class="fa-solid fa-pen-to-square editUser" data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor: pointer"></i>&nbsp;
                                            <i class="fa-solid fa-trash-can deleteUser" style="cursor: pointer"></i>
                                            
                                        
                                        </td>
                                    </tr>   
                                @endforeach
                            @endif
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>

        
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" autocomplete="off" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 alert alert-danger" style="display: none">
                            
                        </div> 
                    </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="first_name" class="label">Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="first_name" id="first_name" >
                        <input type="hidden" id="user_id">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="label">Email</label>
                        <input type="email" class="form-control" autocomplete="off" name="email" id="email" >
                    </div>
                    {{-- <div class="col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="last_name" id="last_name" >
                    </div> --}}
                </div>
                <div class="row mt-2">
                   <div class="col-md-6">
                     <label for="gender" class="label">Gender</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="" disabled selected>--Select--</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                                <option value="3">Transgender</option>
                            </select>
                   </div>

                    <div class="col-md-6" style="display: none">
                        {{-- <label for="user_name">User Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="user_name" id="user_name" value="<?= rand()?>" > --}}
                    </div>

                    <input type="hidden" class="form-control" autocomplete="off" name="user_name_admin" id="user_name_admin" value="<?= rand()?>" >
                    <!-- <div class="col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" autocomplete="off" name="email" id="email" >
                    </div> -->

                    <div class="col-md-6">
                        <label for="role" class="label">Role</label>
                        <select name="role" id="role" class="form-select">
                            <option value="" disabled selected>--Select--</option>
                            @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->role_name}}</option>
                            @endforeach
                        </select>
                    </div>                   
                </div>

                <div class="row mt-2">
                    <div class="col-md-2">
                        <label for="mobile">C.Code</label>   
                        <select name="country_code" id="country_code" class="form-select"> 
                        @foreach ($code as $code)
                            <option value="{{ $code->phonecode}}">{{ $code->phonecode}}&nbsp;({{ $code->iso3 }})</option>
                            @endforeach
                        </select>                                            
                    </div>
                    <div class="col-md-4">
                        <label for="mobile">Mobile Number</label>
                        <input type="number" class="form-control" autocomplete="off" min="0" name="mobile_no" id="mobile_no" > 
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cl" data-bs-dismiss="modal">Close</button>
         
              <button type="button" class="btn btn-primary save_changes_admin">Save changes</button>
            </div>
        </form>
            </div>
           
        </div>
      </div>

    <!-- Modal -->
    
             

      
@endsection