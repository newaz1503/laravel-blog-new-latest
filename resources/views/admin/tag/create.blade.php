@extends('layouts.backend.master')

@section('title','Tag')

@section("css")

@endsection

@section('content')
    <div class="container-fluid">
        <!-- Vertical Layout -->
        <div class="row clearfix">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>Create Tag Name</h2>
                    </div>
                    <div class="body">
                        <form method="POST" action="{{route('admin.tag.store')}}">
                            @csrf
                            <label for="email_address">Tag Name</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="name" value="{{old('name')}} " id="email_address" class="form-control" placeholder="Enter Tag Name">
                                </div>
                                @if ($errors->has('name'))
                                    <span class="invalid feedback" role="alert">
                                         <strong style="color: #e6352c">{{ $errors->first('name') }}.</strong>
                                    </span>
                                @endif
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary m-t-12 waves-effect">Submit</button>
                            <a href="{{route('admin.tag')}}" class="btn btn-danger m-t-12 waves-effect">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Vertical Layout -->

    </div>
@endsection

@section("js")

@endsection

