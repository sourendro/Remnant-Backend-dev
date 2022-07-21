@extends('layouts.admin')

@section('title','Member Management')

@section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <h4>Users list</h4>
                @include('flash-message')
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <th>S.No</th>
                            <th>Profile Image</th>
                            <th>Name</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Last Login</th>
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

                                    if($user_data->gender == 1){
                                        $gender = 'Male';
                                    }else if($user_data->gender == 2){
                                        $gender = 'Female';
                                    }else if($user_data->gender == 3){
                                        $gender = 'Transgender';
                                    }else{
                                        $gender = '';
                                    }
                                   
                                    $status = $user_data->status == 0 ? 'Active' : 'Inactive';

                                    if($user_data->profile_image == ''){
                                        $image = '<img class="img" src ="'.url('/').'/public/images/user-image.png'.'" alt="profile-image">';
                                    }else{
                                        $image = '<img class="img" src ="'.url('/').'/public/images/'.$user_data->profile_image.'" alt="profile-image">';
                                    }
                                @endphp
                                    <tr id="tr_<?=$user_data->id;?>">
                                        <input type="hidden" class="user" value="{{ $user_data->id}}">
                                        <input type="hidden" class="gender" value="{{ $user_data->gender }}">
                                        <input type="hidden" class="status" value="{{ $user_data->status }}"> 
                                        <input type="hidden" class="role" value="{{ $user_data->role }}"> 
                                        <input type="hidden" class="mob_no" value="{{ $user_data->mobile_no }}">
                                        <input type="hidden" class="cun_code" value="{{ $user_data->country_code }}">
                                        <td>{{ $sl++ }}</td>
                                        <td>  <img src="<?= url('storage/app/public/profile_pic').'/'.$user_data->profile_image ?>" alt="profile_pic"> </td>
                                        <td class="name">{{ $user_data->full_name}}</td>
                                        <td class="userName">{{ $user_data->user_name}}</td>
                                        <td class="email">{{ $user_data->email}}</td>
                                        <td class="genderText">{{ $gender}}</td>
                                    
                                        <td>{{ date('d-m-Y h:s',strtotime($user_data->last_login_at))}}</td>
                                        <td>{{ date('d-m-Y h:s',strtotime($user_data->created_at))}}</td>
                                        <td>
                                            <input type="checkbox" style="cursor: pointer" class="status_check" <?= $user_data->status == 0 ? 'checked' : ''?> title="Click for active inactive status" >&nbsp;&nbsp;
                                            
                                            <i class="fa-solid fa-pen-to-square editUser" data-bs-toggle="modal" data-bs-target="#exampleModal" style="cursor: pointer"></i>&nbsp;
                                            <i class="fa-solid fa-circle-info userInfo" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="#tribeModel" ></i>&nbsp;
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
                    <div class="col-md-12">
                        <label for="first_name">Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="first_name" id="first_name" >
                        <input type="hidden" id="user_id">
                    </div>
                    {{-- <div class="col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="last_name" id="last_name" >
                    </div> --}}

                    <input type="hidden" class="form-control" autocomplete="off" name="last_name" id="last_name" value="d" >
                </div>
                <div class="row mt-2">
                   <div class="col-md-6">
                     <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-select">
                                <option value="" disabled selected>--Select--</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                                <option value="3">Transgender</option>
                            </select>
                   </div>

                    <div class="col-md-6">
                        <label for="user_name">User Name</label>
                        <input type="text" class="form-control" autocomplete="off" name="user_name" id="user_name" >
                    </div>
                    
                    
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" autocomplete="off" name="email" id="email" >
                    </div>

                    <div class="col-md-2">
                        <label for="mobile">C.Code</label>   
                        <select name="cuntry_code" id="cuntry_code" class="form-select">                        
                            <option value="" disabled selected>--Select--</option>
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

                <div class="row mt-2">
                <div class="col-md-12">
                <table>
                   <tr>
                        <th><label for="">Are you Born Again ?</label></th>
                        <td><label for=""><input type="radio" name="beliver" class="form-input-check" id="yes" value="1">&nbsp;Yes</label>&nbsp;
                            <label for=""><input type="radio" name="beliver" class="form-input-check" id="no" value="0">&nbsp;No</label></td>
                   </tr>
                   <tr>
                        <th><label for="">Do you need help understanding your dreams ? </label></th>
                        <td><label for=""><input type="radio" name="dreams" class="form-input-check" id="yes1" value="1">&nbsp;Yes</label>&nbsp;
                            <label for=""><input type="radio" name="dreams" class="form-input-check" id="no1" value="0">&nbsp;No</label></td>
                   </tr>
                   <tr>
                        <th><label for="">Do you need prayer ?</label></th>
                        <td><label for=""><input type="radio" name="prayer" class="form-input-check" id="yes2" value="1">&nbsp;Yes</label>&nbsp;
                            <label for=""><input type="radio" name="prayer" class="form-input-check" id="no2" value="0">&nbsp;No</label></td>
                   </tr>
                   <tr>
                        <th><label for="">Do you have questions about the FATHER, SON (JESUS), and HOLY SPIRIT?</label></th>
                        <td><label for=""><input type="radio" name="question" class="form-input-check" id="yes3" value="1">&nbsp;Yes</label>&nbsp;
                            <label for=""><input type="radio" name="question" class="form-input-check" id="no3" value="0">&nbsp;No</label></td>
                   </tr>
                   <tr>
                        <th><label for="">Did you attend a recent WeRemnant event?</label></th>
                        <td><label for=""><input type="radio" name="event" class="form-input-check" id="yes4" value="1">&nbsp;Yes</label>&nbsp;
                            <label for=""><input type="radio" name="event" class="form-input-check" id="no4" value="0">&nbsp;No</label></td>
                    </tr>
                    <tr>
                        <th><label for="">Are you baptized with the HOLY SPIRIT?</label></th>
                        <td><label for=""><input type="radio" name="holy_spirit" class="form-input-check" id="yes5" value="1">&nbsp;Yes</label>&nbsp;
                            <label for=""><input type="radio" name="holy_spirit" class="form-input-check" id="no5" value="0">&nbsp;No</label></td>
                    </tr>
                </table>
                </div>
                </div>


                    <div class="row">
                    <div class="col-md-6">
                    
                        <input type="hidden" name="role" id="role" value="0">
                        {{-- <label for="role" class="label">Role</label> --}}
                        {{-- <select name="role" id="role" class="form-select">
                            <option value="" disabled selected>--Select--</option>
                            @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->role_name}}</option>
                            @endforeach
                        </select> --}}
                    </div>
                
                    
                    
                    </div>

                


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cl" data-bs-dismiss="modal">Close</button>
         
              <button type="button" class="btn btn-primary save_changes">Save changes</button>
            </div>
        </form>
            </div>
           
        </div>
      </div>



      <div class="modal fade" id="tribeModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Subscribe Tribes</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="{{ url('admin/make-tribe-subscribe')}}" autocomplete="off" method="post">
                    @csrf
                        <input type="hidden" id="modal_user_id" name="user_id" >
                       
                        <div class="row subscribe_list">
                      

                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cl" data-bs-dismiss="modal">Close</button>
                
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
           
        </div>
      </div>

    <!-- Modal -->
    
             
      <style>
        .table img {
            width: 53px;
            height: 55px;
        }
      </style>


<script>
        $('.editUser').click(function(){
        var user_id = $(this).parent('td').parent('tr').find('.user').val();
        //alert(user_id);
            $.ajax({
                type: "POST",
                url: "{{url('admin/select_userinfo')}}",
                data: {id:user_id, _token : csrf_token},
                success: function (response) {
                   console.log(response);  
                //     return false;
                  if (response.new_believer == 0) {
                    var $beliver = 'no';                    
                  }else{
                    var $beliver = 'yes';
                  };

                  if (response.understanding_dreams == 0) {
                    var $dreams = 'no1';                    
                  }else{
                    var $dreams = 'yes1';
                  };
                
                  if (response.need_prayer == 0) {
                    var $need_pray = 'no2';                    
                  }else{
                    var $need_pray = 'yes2';
                  };

                  if (response.ques_about_jesus == 0) {
                    var $ques_Jesus = 'no3';                    
                  }else{
                    var $ques_Jesus = 'yes3';
                  };

                  if (response.event_attend == 0) {
                    var $attend_evnt = 'no4';                    
                  }else{
                    var $attend_evnt = 'yes4';
                  };

                  if (response.holy_spirit == 0) {
                    var $holy_spirit = 'no5';                    
                  }else{
                    var $holy_spirit = 'yes5';
                  };

                  $("#first_name").val(response.full_name);
                    $("#user_id").val(user_id);
                    $("#last_name").val(response.last_name);
                    $("#email").val(response.email);
                    $("#user_name").val(response.user_name);
                    $("#gender").val(response.gender).change();

                    var c_code = response.country_code;
                    c_code = c_code.replace('+', '');
                    
                    $("#cuntry_code").val(c_code).change();

                    $("#mobile_no").val(response.mobile_no);
                    $("#"+$beliver).prop('checked',true);
                    $("#"+$dreams).prop('checked',true);
                    $("#"+$need_pray).prop('checked',true);
                    $("#"+$ques_Jesus).prop('checked',true);
                    $("#"+$attend_evnt).prop('checked',true);
                    $("#"+$holy_spirit).prop('checked',true);

                }
            });

        })


    $('.userInfo').click(function(){
        var user_id = $(this).parent('td').parent('tr').find('.user').val();

        $.ajax({
            type: "POST",
            url: APP_URL+"/admin/fetch_subscribe_tribe",
            data: {id:user_id, _token : csrf_token},
            success: function (response) {
                $('.subscribe_list').html(response);
            }
        });
        $("#modal_user_id").val(user_id);
    });
</script>
      
@endsection