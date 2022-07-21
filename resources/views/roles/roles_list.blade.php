    @extends('layouts.admin')

    @section('title','Roles')

    @section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <h4>Roles <a href="{{ url('admin/add-role')}}" style="float: right" class="btn btn-primary">Add New Role</a></h4>

                @include('flash-message')
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <th>S.No</th>
                            <th>Role Name</th>
                            <th>Note</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $sl++}}</td>
                                    <td>{{ $role->role_name}}</td>
                                    <td>{{ $role->note}}</td>
                                    <td><a href="{{ url('admin/'.$role->id.'/edit-role')}}" class="btn btn-dark btn-sm">Edit</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection