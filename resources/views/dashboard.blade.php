@extends('layouts.admin')

@section('title','Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <h4>Welcome to Remnant Admin Panel</h4>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3"><h6>Total Registered Users in the App </h6> </div>
                        <div class="col-md-3"><h6>Active Users Today </h6></div>
                        <div class="col-md-3"><h6>Total Events </h6></div>
                        <div class="col-md-3"><h6>Total Events Created </h6></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">{{$registration_user}}</div>
                        <div class="col-md-3">{{$active_user}}</div>
                        <div class="col-md-3">{{$total_events}}</div>
                        <div class="col-md-3">{{$total_created_events}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><h6>Total Events Active</h6></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">{{$total_active_events}}</div>
                    </div>
                </div>
                
               {{-- <div class="row">
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
                                   
                                  

                                    if($user_data->profile_image == ''){
                                        $image = '<img class="img" src ="'.url('/').'/public/images/user-image.png'.'" alt="profile-image">';
                                    }else{
                                        $image = '<img class="img" src ="'.url('/').'/public/images/'.$user_data->profile_image.'" alt="profile-image">';
                                    }
                                @endphp
                                    <tr id="tr_<?=$user_data->id;?>">
                                        <td>{{ $sl++ }}</td>
                                        <td style="max-width : 100%">  <img src="<?= url('storage/app/public/profile_pic').'/'.$user_data->profile_image ?>" alt="profile_pic"> </td>
                                        <td class="name">{{ $user_data->full_name}}</td>
                                        <td class="userName">{{ $user_data->user_name}}</td>
                                        <td class="email">{{ $user_data->email}}</td>
                                        <td class="genderText">{{ $gender}}</td>
                                    
                                        <td>{{ date('d-m-Y h:s',strtotime($user_data->last_login_at))}}</td>
                                        <td>{{ date('d-m-Y h:s',strtotime($user_data->created_at))}}</td>
                                    </tr>   
                                @endforeach
                            @endif
                        </tbody>
                        
                    </table>
                </div>
            </div> --}}
            <br><br<br>
            <h5>User Approval Details</h5>
            <div class="row">
                <div class="col-md-6">
                    <table class="table"></table>
                </div>
            </div>
            <br><br<br><br><br>
            <h5>Contact Us Details</h5>
            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <th>S.No</th>
                            <th>Display Name</th>
                            <th>Contact No</th>
                            <th>Email</th>
                            <th>Message</th>
                        </thead> 
                        <tbody>
                        @php
                                $sl = 1;
                        @endphp
                        @foreach($contact_details as $contact)
                        <tr>             
                            <td>{{ $sl++}}</td>
                            <td>{{ $contact->contact_name}}</td>
                            <td>{{$contact->contact_no}}</td>
                            <td>{{ $contact->contact_email}}</td>
                            <td>{{ $contact->contact_message}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



            </div>
        </div>
    </div>
@endsection