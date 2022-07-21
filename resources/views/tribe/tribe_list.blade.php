@extends('layouts.admin')

@section('title','Tribe')

@section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <div class="row">
                    <h4>Tribe List <a href="{{ url('admin/add-new-tribe') }}" style="float: right" class="btn btn-primary">Add New Tribe</a></h4>
                    @include('flash-message')
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <th>S.No</th>
                                <th>Tribe Name</th>
                                <th>Note</th>
                                <th>Privacy</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach($tribe_list as $tribe)
                                @php
                                    $color = $tribe->privacy == 0 ? 'primary' : 'secondary';
                                    $privacy_text = $tribe->privacy == 0 ? 'Public' : 'Private';
                                @endphp
                                <tr>
                                    <input type="hidden" class="id" value="{{$tribe->id }}">
                                    <input type="hidden" class="status" value="{{$tribe->status }}">
                                    <td>{{ $sl++}}</td>
                                    <td>{{ $tribe->tribe_name}}</td>
                                    <td>{{ $tribe->note}}</td>
                                    <td><span class="badge rounded-pill bg-{{ $color }}">{{ $privacy_text}}</span></td>
                                    <td>{{ date('d-m-Y',strtotime($tribe->created_at))}}</td>
                                    <td>
                                        <input type="checkbox" style="cursor: pointer" class="tribe_status" <?= $tribe->status == 0 ? 'checked' : ''?> title="Click for active inactive status" >&nbsp;&nbsp;

                                        <a href="{{ url('admin/'.$tribe->id.'/edit-tribe')}}" class="black"><i class="fa-solid fa-pen-to-square" style="cursor: pointer"></i></a>&nbsp;
                                        <a href="{{ url('admin/'.$tribe->id.'/delete-tribe')}}" class="black"><i class="fa-solid fa-trash-can delete" style="cursor: pointer"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .black{
            color: #000;
        }
    </style>
    <script>
        $('.delete').click(function(){

            if(confirm('Do you want to delete this record ?')){

            }else{
                return false;
            }
        });


        $(".tribe_status").click(function(){

            that = $(this);
            var id = $(this).parent('td').parent('tr').find('.id').val();
            var CSRF = "{{ csrf_token() }}";
            if($(this).is(":checked")){
                $.ajax({
                    type: "POST",
                    url: APP_URL+"/admin/tribe-status-update",
                    data: {id: id, update : 0, _token:CSRF},
                    success: function (response) {
                        swal({
                            title: "Success!",
                            text: "Tribe is now Active!",
                            icon: "success",
                            button: "Ok!",
                        });
                    }
                });
            }else{
                
                $.ajax({
                    type: "POST",
                    url: APP_URL+"/admin/tribe-status-update",
                    data: {id: id, update : 1, _token:CSRF},
                    success: function (response) {
                        swal({
                            title: "Success!",
                            text: "Tribe is now Inactive!",
                            icon: "success",
                            button: "Ok!",
                        });
                    }
                });
            }
            });
    </script>
    
@endsection


        
