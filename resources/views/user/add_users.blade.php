<?php
session_start();
?>
@extends('layouts.admin')

@section('title','New User Add')

@section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <h4>New User Add</h4>

                
                @include('flash-message')
                <form method="POST" action="{{ url('admin/user-store') }}" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="first_name" class="label">Name</label>
                            <input type="text" name="first_name" id="first_name" placeholder="Enter Name" value="{{ Session::get('first_name')}}" class="form-control" required>
                        </div>

                        {{-- <div class="col-md-4">
                            <label for="last_name" class="label">Last Name</label>                           
                            </div> --}}

                        <input type="hidden" name="last_name" id="last_name" placeholder="Enter Last Name" class="form-control" value="d">
                        <div class="col-md-6">
                            <?php
                                $form_back_value = Session::get('gender');    
                                
                            ?>
                            <label for="gender" class="label">Gender</label>
                                <select name="gender" id="gender" class="form-select" required>
                                    <option value=""  selected>--Select--</option>
                                    <option value="1"
                                        <?php
                                            if($form_back_value == 1){
                                                echo 'selected';
                                            }
                                        
                                        ?>
                                    >Male</option>
                                    <option value="2"
                                    <?php
                                            if($form_back_value == 2){
                                                echo 'selected';
                                            }
                                        
                                        ?>
                                    >Female</option>
                                    <option value="3"
                                    <?php
                                            if($form_back_value == 3){
                                                echo 'selected';
                                            }
                                        
                                        ?>
                                    >Transgender</option>
                                </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        {{-- <div class="col-md-4">
                            <label for="user_name" class="label">User Name</label>
                            <input type="text" name="user_name" placeholder="Enter User Name" id="user_name" class="form-control">
                        </div> --}}
                        <input type="hidden" name="user_name" placeholder="Enter User Name" id="user_name" class="form-control" value="<?= 'user_'.rand()?>">
                        <div class="col-md-4">
                            <label for="email" class="label">Email</label>
                            <input type="email" name="email" id="email" placeholder="example@test.com" class="form-control" value="{{ Session::get('email')}}"required>
                        </div>
                        <div class="col-md-4">
                            <label for="password" class="label">Password</label>
                            <input type="password" name="password" title="One upper case , One lower case, One special charecter , One Number , lenght 8 - 16 " minlength="8" maxlength="16" id="password" placeholder="**********" class="form-control" required>
                            
                        </div>
                        <div class="col-md-4">
                            <label for="role" class="label">Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="" selected>--Select--</option>
                                @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" @if($role->id == Session::get('role')) selected="selected" @endif>{{ $role->role_name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                    <div class="col-md-2">
                        <label for="mobile">C.Code</label>   
                        <select name="cuntry_code" id="cuntry_code" class="form-select">                        
                            <option value="" disabled selected>--Select--</option>
                            @foreach ($code as $code)
                            <?php if($code->phonecode == 1){
                                $us="selected";
                            }else{
                                $us="";
                            }
                             ?>
                            <option value="{{ $code->phonecode}}" {{$us}}>{{ $code->phonecode}}&nbsp;({{ $code->iso3 }})</option>
                            @endforeach
                        </select>                    
                        
                    </div>

                    <div class="col-md-4">
                        <label for="mobile">Mobile Number</label>
                        <input type="number" class="form-control" autocomplete="off" min="0" name="mobile_no" id="mobile_no" > 
                    </div>
                </div>

                {{--<div class="row mt-2">
                <div class="col-md-12">
                <table>
                   <tr>
                        <th><label for="">Are you a new believer in LORD JESUS CHRIST ?</label></th>
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
                        <th><label for="">Do you have questions about LORD JESUS CHRIST ?</label></th>
                        <td><label for=""><input type="radio" name="question" class="form-input-check" id="yes3" value="1">&nbsp;Yes</label>&nbsp;
                            <label for=""><input type="radio" name="question" class="form-input-check" id="no3" value="0">&nbsp;No</label></td>
                   </tr>
                   <tr>
                        <th><label for="">Did you attend a recent WeRemnant event?</label></th>
                        <td><label for=""><input type="radio" name="event" class="form-input-check" id="yes4" value="1">&nbsp;Yes</label>&nbsp;
                            <label for=""><input type="radio" name="event" class="form-input-check" id="no4" value="0">&nbsp;No</label></td>
                    </tr>
                </table>
                </div>
                </div> --}}
                   


                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
        <?php
        
        Session::put('first_name', '');
        Session::put('email', '');
        Session::put('gender', '');
        Session::put('role', '');
        Session::put('mobile_no', '');
        
        ?>
    <script>
        $("#password").focus(function(){
            $("#password").attr('type','text');
        });

        $("#password").blur(function(){
            $("#password").attr('type','password');
        });
    </script>
@endsection