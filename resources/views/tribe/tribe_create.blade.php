@extends('layouts.admin')

@section('title','Create New Tribe')

@section('content')
    <div class="container-fluid">
        <div class="main-page-content">
            <div id="firstTab" class="tabcontent">
                <div class="row">
                    <h4>Create New Tribe</h4>
                    @include('flash-message')
                </div>
                
                <form method="POST" action="{{ url('admin/tribe-store') }}" autocomplete="off">
                @csrf
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="" class="label">Tribe Name</label>
                        <input type="text" name="tribe_name" id="tribe_name" placeholder="Enter New Tribe Name" class="form-control" required>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <label for="note" class="label">Note</label>
                        <textarea type="text" name="note" id="note" rows="5" cols="5" class="form-control"></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
            </div>
        </div>
    </div>
@endsection