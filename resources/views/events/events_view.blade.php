@extends('layouts.admin')

@section('title','Event')

@section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <div class="row">
                    <h4>Event List <a href="{{ url('admin/create-new-event') }}" style="float: right" class="btn btn-primary">Add New Event</a></h4>
                    @include('flash-message')
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <th>S.No</th>
                                <th>Event Name</th>
                                <th>Description</th>
                                <th>Event Date</th>
                                <th>Event Time</th>
                                <th>Privacy</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach($event_list as $event)
                                @php
                                    $color = $event->privacy == 0 ? 'primary' : 'secondary';
                                    $privacy_text = $event->privacy == 0 ? 'Public' : 'Private';
                                @endphp
                                <tr>
                                    <input type="hidden" class="id" value="{{$event->id }}">
                                    <input type="hidden" class="status" value="{{$event->status }}">
                                    <td>{{ $sl++}}</td>
                                    <td>{{ $event->event_name}}</td>
                                    <td>{!!$event->description!!}</td>
                                    <td>{{ $event->event_date}}</td>
                                    <td>{{ $event->event_time}}</td>
                                    <td><span class="badge rounded-pill bg-{{ $color }}">{{ $privacy_text}}</span></td>
                                    <td>{{ date('d-m-Y',strtotime($event->created_at))}}</td>
                                    <td>
                                    <input type="checkbox" style="cursor: pointer" class="event_status" <?= $event->status == 0 ? 'checked' : ''?> title="Click for active inactive status" >&nbsp;&nbsp;

                                    <a href="{{ url('admin/'.$event->id.'/edit-event')}}" class="black"><i class="fa-solid fa-pen-to-square" style="cursor: pointer"></i></a>&nbsp;

                                    <a href="{{ url('admin/'.$event->id.'/delete-event')}}" class="black"><i class="fa-solid fa-trash-can delete" style="cursor: pointer"></i></a>
                                    </td>
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

        if(confirm('Do you want to delete this Event ?')){

        }else{
            return false;
        }
        });


    $(".event_status").click(function(){
        that = $(this);
        var id = $(this).parent('td').parent('tr').find('.id').val();
        var CSRF = "{{ csrf_token() }}";
        if($(this).is(":checked")){
            $.ajax({
                type: "POST",
                url: APP_URL+"/admin/event-status-update",
                data: {id: id, update : 0, _token:CSRF},
                success: function (response) {
                    swal({
                        title: "Success!",
                        text: "Event is now Active!",
                        icon: "success",
                        button: "Ok!",
                    });
                }
            });
        }else{
            
            $.ajax({
                type: "POST",
                url: APP_URL+"/admin/event-status-update",
                data: {id: id, update : 1, _token:CSRF},
                success: function (response) {
                    swal({
                        title: "Success!",
                        text: "Event is now Inactive!",
                        icon: "success",
                        button: "Ok!",
                    });
                }
            });
        }
        });
</script>

    
    
@endsection


        
