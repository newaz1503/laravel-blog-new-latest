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
                        <h2>Edit Tag Name</h2>
                    </div>
                    <div class="body">
                        <form method="POST" action="{{route('admin.category.update',$category->id)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <label for="email_address">Category Name</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="name" value="{{$category->name}} " id="email_address" class="form-control" placeholder="Enter Tag Name">
                                </div>
                                @if ($errors->has('name'))
                                    <span class="invalid feedback" role="alert">
                                         <strong style="color: #e6352c">{{ $errors->first('name') }}.</strong>
                                    </span>
                                @endif
                            </div>
                            <label for="email_address">Category Image</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="file" name="image">
                                </div>
                                <div class="m-t-10">
                                    <img src="{{ asset('storage/category/'.$category->image)}}" alt="{{$category->name}}" width="150" height="100" class="img-fluid">
                                </div>
                                @if ($errors->has('image'))
                                    <span class="invalid feedback" role="alert">
                                         <strong style="color: #e6352c">{{ $errors->first('image') }}.</strong>
                                    </span>
                                @endif
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary m-t-12 waves-effect">Update</button>
                            <a href="{{route('admin.category')}}" class="btn btn-danger m-t-12 waves-effect">Back</a>
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

