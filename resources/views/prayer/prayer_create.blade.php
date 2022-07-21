@extends('layouts.admin')

@section('title','Prayer Create')

@section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Prayer Create</h4>
                        @include('flash-message')
                    </div>
                </div>

                <form method="post" action="{{ url('admin/prayer-store') }}" enctype="multipart/form-data" autocomplete="off">
                @csrf
                
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="" class="label">Title</label>
                        <input type="text" name="title" maxlength="30" class="form-control" id="title" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="" class="label">Description</label>
                        <textarea  name="description" class="form-control" cols="10" rows="5" id="description"></textarea>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-3">
                        <label for="" class="label">File Type</label><br>

                        <label for="audio"><input type="radio" class="form-input-check" required name="file_type" id="audio" value="1">&nbsp;Audio</label>
                        &nbsp;
                        &nbsp;
                        <label for="image"><input type="radio" class="form-input-check" required name="file_type" id="image" value="2">&nbsp;Image</label>
                        &nbsp;
                        <label for="video"><input type="radio" class="form-input-check" required name="file_type" id="video" value="3">&nbsp;Video</label>
                       
                    </div>


                    <div class="col-md-4 audio" style="display: none">
                        <label for="" class="label">Upload Audio</label>
                        <input type="file" class="form-control" name="audio_file" id="audio_file" accept="audio/*">
                    </div>

                    <div class="col-md-4 image" style="display: none">
                        <label for="" class="label">Upload Image</label>
                        <input type="file" class="form-control" name="image_file" id="image_file" accept="image/jpeg,image/jpg,image/png">
                    </div>

                    <div class="col-md-4 video_type" style="display: none">
                        <label for="" class="label">Video Type</label>
                        <select name="video_type" class="form-select" id="video_type">
                            <option value="">--Select--</option>
                            <option value="1">Youtube Video</option>
                            <option value="2">Vimeo Video</option>
                            <option value="3">Custom Video</option>
                        </select>
                    </div>


                    <div class="col-md-4 for_youtube_vimoo" style="display: none">
                        <label for="" class="label">Add Link</label>
                        <input type="text" name="links" id="links" class="form-control">
                    </div>

                    <div class="col-md-4 upload_video" style="display: none">
                        <label for="" class="label">Upload Video</label>
                        <input type="file" name="video_file" class="form-control" id="video_file" class="form-control">
                    </div>
                    <div class="col-md-4 upload_video" style="display: none"></div>
                    <div class="col-md-3 upload_video" style="display: none"></div>
                    <div class="col-md-4 upload_video" style="display: none">
                        <label for="" class="label">Upload Thumbnail</label>
                        <input type="file" class="form-control" name="video_thumbnail" id="video_thumbnail" accept="image/jpeg,image/jpg,image/png" required>
                    </div>
                    <!-- <div class="col-md-4 upload_video" style="display: none">
                        <label for="" class="label">Upload Thumbnail</label>
                        <input type="file" name="video_thumbnail" class="form-control" id="video_thumbnail" class="form-control">
                    </div> -->


                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>


    
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