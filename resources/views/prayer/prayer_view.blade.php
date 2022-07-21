@extends('layouts.admin')

@section('title','Prayer List')

@section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Prayer View <a href="{{ url('admin/create-new-prayer')}}" class="btn btn-primary" style="float: right">Create New Prayer</a></h4>
                    </div>
                </div>
               

                <div class="row mt-2">
                    <div class="col-md-12">
                        <table class="table">
                            <thead class="table-primary">
                           
                                {{-- <th>Image</th> --}}
                                <th>Title</th>
                                <th>Description</th>
                                <th>Uploaded File</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                    @foreach ($prayers_list as $prayers)


                                        <tr>
                                            {{-- <td><img src="{{ url('storage/app/public/prayers_file/'.$prayers->file)}}" alt="prayers_image"></td> --}}
                                            <td>{{ $prayers->title }}</td>
                                            <td><?= strip_tags($prayers->description) ?></td>
                                            <td>
                                                @if($prayers->file_type == 2)    
                                                <img src="{{ url('storage/app/public/prayers_file/'.$prayers->file)}}" alt="prayers_image">
                                                @elseif($prayers->file_type == 1)
                                                <audio controls>
                                                    <source src="{{ url('storage/app/public/prayers_file/'.$prayers->file)}}" type="audio/mp3">
                                                   
                                                  </audio>
                                                @elseif($prayers->file_type == 3)

                                                    @if($prayers->video_type == 3)

                                                    <video controls>
                                                        <source src="{{ url('storage/app/public/prayers_file/'.$prayers->file)}}" type="video/mp4">
                                                      
                                                      </video>  
                                                    @elseif($prayers->video_type == 1)
                                                  
                                                        {{--<source src="{{ $prayers->links }}" type="video/mp4">
                                                        <iframe src="{{ $prayers->links }}" width="172px" height="120px"></iframe>--}}
                                                       
                                                        <iframe width="172px" height="120px" src="{{ $prayers->links }}" >
                                                        </iframe>
                                                                                                         

                                                    @endif

                                                    
                                                @endif
                                            </td>
                                            <td>{{ date('m-d-Y',strtotime($prayers->created_at)) }}</td>
                                            <td><a href="<?= url('/').'/admin/'.$prayers->id.'/edit-prayer';?>" class="btn btn-secondary btn-sm">Edit</a></td>
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
        img{
            width: 139px;
            height: 138px;
            border-radius: 50%;
        }

        video {
            width: 172px;
            height: 120px;
        }
    </style>
@endsection