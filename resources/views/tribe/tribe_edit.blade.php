@extends('layouts.admin')

@section('title','Edit Tribe')

@section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <div class="row">
                    <h4>Edit Tribe</h4>
                    @include('flash-message')
                </div>
                
                <form method="POST" action="{{ url('admin/update-tribe') }}" autocomplete="off">
                @csrf
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="" class="label">Tribe Name</label>
                        <input type="text" name="tribe_name" id="tribe_name" placeholder="Enter New Tribe Name" class="form-control" value="{{ $tribe_details->tribe_name}}" required>
                        <input type="hidden" name="tribe_id" value="{{ $tribe_details->id }}">
                    </div>

                    <div class="col-md-6">
                        <label for="" class="label">Tribe Privacy</label><br>
                        <label for="public"><input type="radio" class="form-input-check" name="privacy" value="0" <?= $tribe_details->privacy == 0 ? 'checked' : ''?> id="public">&nbsp;Public</label>
                        

                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <label for="private"><input type="radio" class="form-input-check" name="privacy" <?= $tribe_details->privacy == 1 ? 'checked' : ''?>  id="private" value="1">&nbsp;Private</label>
                        
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="note" class="label">Note</label>
                        <textarea type="text" name="note" id="note" rows="5" cols="5" class="form-control">{{ $tribe_details->note}}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
            </div>
        </div>
    </div>
@endsection