@extends('layouts.backend.master')

@section('title','Post')

@section("css")
    <!-- Select Plugin Js -->
    <!-- Bootstrap Select Css -->
    <link href="{{asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Vertical Layout -->
        <form method="POST" action="{{route('admin.post.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Create New Post</h2>
                        </div>
                        <div class="body">
                            <label for="email_address">Title</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="text" name="title" value="{{old('title')}} " id="email_address" class="form-control" placeholder="Enter Post title">
                                </div>
                                @if ($errors->has('title'))
                                    <span class="invalid feedback" role="alert">
                                         <strong style="color: #e6352c">{{ $errors->first('title') }}.</strong>
                                    </span>
                                @endif
                            </div>
                            <label for="email_address">Feature Image</label>
                            <div class="form-group">
                                <div class="form-line">
                                    <input type="file" name="image">
                                </div>
                                @if ($errors->has('image'))
                                    <span class="invalid feedback" role="alert">
                                         <strong style="color: #e6352c">{{ $errors->first('image') }}.</strong>
                                    </span>
                                @endif
                            </div>

                            <input type="checkbox" name="status" id="publish" class="filled-in" value="1">
                            <label for="publish">Publish</label>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Category & Tag</h2>
                        </div>
                        <div class="body">
                            <div class="form-group form-floating">
                                <div class="form-line" {{$errors->has('categories') ? 'focused error' : ''}}>
                                    <label for="form-label">Select Category</label>
                                    <select name="categories[]" class="form-control show-tick" multiple data-live-search="true">
                                        @foreach($categories as $category)
                                             <option value="{{$category->id}}" style="padding-left: 50px">{{$category->name}}</option>
                                        @endforeach()
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-floating">
                                <div class="form-line" {{$errors->has('tags') ? 'focused error' : ''}}>
                                    <label for="form-label">Select Tag</label>
                                    <select name="tags[]" class="form-control show-tick" multiple data-live-search="true">
                                        @foreach($tags as $tag)
                                            <option value="{{$tag->id}}" style="padding-left: 50px">{{$tag->name}}</option>
                                        @endforeach()
                                    </select>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary m-t-12 waves-effect">Publish</button>
                            <a href="{{route('admin.post')}}" class="btn btn-danger m-t-12 waves-effect">Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Post Description</h2>
                        </div>
                        <div class="body">
                            <textarea id="tinymce" name="description">

                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->
        </form>
    </div>
@endsection

@section("js")
    <!-- Select Plugin Js -->
    <script src="{{asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>
    <!-- TinyMCE -->
    <script src="{{asset('assets/backend/plugins/tinymce/tinymce.js')}}"></script>
    <script>
        $(function () {
            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{asset('assets/backend/plugins/tinymce')}}';
        });
    </script>
@endsection

