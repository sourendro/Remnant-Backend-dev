@extends('layouts.admin')

@section('title','Edit Tribe')

@section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <div class="row">
                    <h4>Create Event</h4>
                    @include('flash-message')
                </div>
                
                <form method="POST" action="{{ url('admin/event-store') }}" autocomplete="off">
                @csrf
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="" class="label">Event Name</label>
                        <input type="text" name="event_name" id="event_name" placeholder="Enter event Name" class="form-control" required>
                    </div>

                    <div class="col-md-6"> 
                        <label for="" class="label">Tribe Privacy</label><br>
                        <label for="public"><input type="radio" class="form-input-check" name="privacy" id="public" value="0" >&nbsp;Public</label>
                        
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="private"><input type="radio" class="form-input-check" name="privacy" id="private" value="1">&nbsp;Private</label>
                        
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                    <label for="" class="label">Event Date</label>
                        <input type="date" name="event_date" id="event_date" placeholder="Enter event Date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                    <label for="" class="label">Event Time</label>
                        <input type="time" name="event_time" id="event_time" placeholder="Enter event Time" class="form-control" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="" class="label">Description</label>
                        <textarea  name="description" id="description" class="form-control" cols="10" rows="5" id="description"></textarea>
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