@extends('layouts.admin')

@section('title','Edit Event')

@section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <div class="row">
                    <h4>Edit Event</h4>
                    @include('flash-message')
                </div>
                
                <form method="POST" action="{{ url('admin/update-event') }}" autocomplete="off">
                @csrf
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="" class="label">Event Name</label>
                        <input type="text" name="event_name" id="event_name" placeholder="Enter New Event Name" class="form-control" value="{{ $event_details->event_name}}" required>
                        <input type="hidden" name="event_id" value="{{ $event_details->id }}">
                    </div>

                    <div class="col-md-6">
                        <label for="" class="label">Event Privacy</label><br>
                        <label for="public"><input type="radio" class="form-input-check" name="privacy" value="0" <?= $event_details->privacy == 0 ? 'checked' : ''?> id="public">&nbsp;Public</label>
                        

                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="private"><input type="radio" class="form-input-check" name="privacy" <?= $event_details->privacy == 1 ? 'checked' : ''?>  id="private" value="1">&nbsp;Private</label>
                        
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="description" class="label">Description</label>
                        <textarea type="text" name="description" id="description" rows="5" cols="5" class="form-control">{{ $event_details->description}}</textarea>
                    </div>
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
</script>
@endsection