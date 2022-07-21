@extends('layouts.admin')

@section('title','Prayer Create')

@section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Prayer Edit</h4>
                        @include('flash-message')
                    </div>
                </div>

                <form method="post" action="{{ url('admin/prayer-update') }}" enctype="multipart/form-data" autocomplete="off">
                @csrf
                
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="" class="label">Title</label>
                        <input type="text" name="title" class="form-control" id="title" required value="{{ $prayers_details->title }}">

                        <input type="hidden" name="prayers_id" value="{{ $prayers_details->id }}">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="" class="label">Description</label>
                        <textarea  name="description" class="form-control" cols="10" rows="5" id="description">{!! $prayers_details->description !!}</textarea>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="" class="label">File Type</label><br>

                        <label for="audio"><input type="radio" class="form-input-check" <?= $prayers_details->file_type == 1 ? 'checked': '';?> required name="file_type" id="audio" value="1">&nbsp;Audio</label>
                        &nbsp;
                        &nbsp;
                        <label for="image"><input type="radio" class="form-input-check"  <?= $prayers_details->file_type == 2 ? 'checked': '';?> required name="file_type" id="image" value="2">&nbsp;Image</label>
                        &nbsp;
                        <label for="video"><input type="radio" class="form-input-check"  <?= $prayers_details->file_type == 3 ? 'checked': '';?> required name="file_type" id="video" value="3">&nbsp;Video</label>
                       
                    </div>


                    <div class="col-md-4 audio" <?= $prayers_details->file_type == 1 ? 'style="display: block"': 'style="display: none"';?> >
                        <label for="" class="label">Upload Audio</label>
                        <input type="file" class="form-control mb-2" name="audio_file" id="audio_file" accept="audio/*">

                        @if($prayers_details->file_type == 1)
                        <audio controls >
                            <source src="{{ url('storage/app/public/prayers_file/'.$prayers_details->file)}}" type="audio/mp3">
                           
                          </audio>
                        @endif

                    </div>

                    <div class="col-md-4 image"  <?= $prayers_details->file_type == 2 ? 'style="display: block"': 'style="display: none"';?>>
                        <label for="" class="label">Upload Image</label>
                        <input type="file" class="form-control" name="image_file" id="image_file" accept="image/jpeg,image/jpg,image/png">

                        @if($prayers_details->file_type == 2)
                        <img src="{{ url('storage/app/public/prayers_file/'.$prayers_details->file)}}" alt="image" class="mt-2">
                        @endif
                    </div>

                    <div class="col-md-4 video_type" <?= $prayers_details->file_type == 3 ? 'style="display: block"': 'style="display: none"';?>>
                        <label for="" class="label">Video Type</label>
                        <select name="video_type" class="form-select" id="video_type">
                            <option value="">--Select--</option>
                            <option value="1" <?= $prayers_details->video_type == 1 ? 'selected' : '' ?> >Youtube Video</option>
                            <option value="2" <?= $prayers_details->video_type == 2 ? 'selected' : '' ?>>Vimoo Video</option>
                            <option value="3" <?= $prayers_details->video_type == 3 ? 'selected' : '' ?>>Upload Video</option>
                        </select>
                    </div>


                    <div class="col-md-4 for_youtube_vimoo" style="display: none">
                        <label for="" class="label">Add Link</label>
                        <input type="text" name="links" id="links" class="form-control">
                    </div>

                    <div class="col-md-4 upload_video" <?= $prayers_details->video_type == 3 ? 'style="display: block"': 'style="display: none"';?>>
                        <label for="" class="label">Upload Video</label>
                        <input type="file" name="video_file" class="form-control mb-3" id="video_file" class="form-control">

                        @if( $prayers_details->video_type == 3 && $prayers_details->file_type == 3)
                        <video controls>
                            <source src="{{ url('storage/app/public/prayers_file/'.$prayers_details->file)}}" type="video/mp4">
                          
                          </video>

                       
                          @endif

                    </div>

                    <div class="col-md-4 upload_video" <?= $prayers_details->video_type == 1 ? 'style="display: block"': 'style="display: none"';?>>
                    <label for="" class="label">Upload Link</label>
                        <input type="text" name="video_file_link" class="form-control mb-3" id="video_file_link" class="form-control" value="{{$prayers_details->links}}">

                    @if( $prayers_details->video_type == 1 && $prayers_details->file_type == 3)
                                <iframe width="172px" height="120px" src="{{ $prayers_details->links }}" >
                                                        </iframe>
                    @endif
                    </div>


                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
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
            width: 355px;
            height: 200px;
        }
   
    </style>
    <script src="//cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
    <script>

        CKEDITOR.replace('description', {
            width: '100%',
            height: 300,
            removeButtons: 'PasteFromWord'
        });
        $("input[name='file_type']").click(function(){

            var value = $(this).val();

            
            if(value == 1){
                $('.audio').show();
                $('.image').hide();
                $('.video_type').hide();
                $('.upload_video').hide();
                $('.for_youtube_vimoo').hide();

                $('#audio_file').prop('required',true);
                $('#image_file').removeAttr('required');
                $('#video_type').removeAttr('required');
            }else if (value == 3){
                $('.video_type').show();
                $('.audio').hide();
                $('.image').hide();
                $('.upload_video').hide();
                $('.for_youtube_vimoo').hide();

                $('#video_type').prop('required',true);
                $('#audio_file').removeAttr('required');
                $('#image_file').removeAttr('required');

            }else{
                $('.video_type').hide();
                $('.audio').hide();
                $('.image').show();
                $('.upload_video').hide();
                $('.for_youtube_vimoo').hide();

                $('#image_file').prop('required',true);
                $('#audio_file').removeAttr('required');
                $('#video_type').removeAttr('required');

            }
        });


        $("#video_type").change(function(){
            var select_value = $(this).val();

            if(select_value == ''){
                $('.upload_video').hide();
                $('.for_youtube_vimoo').hide();

            } else if (select_value == 3){
                $('.upload_video').show();
                $('.for_youtube_vimoo').hide();
            }else{
                $('.upload_video').hide();
                $('.for_youtube_vimoo').show();
            }
        });
    </script>
@endsection