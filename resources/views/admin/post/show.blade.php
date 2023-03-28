@extends('layouts.backend.master')

@section('title','Post')

@section("css")
    <!-- Select Plugin Js -->
    <!-- Bootstrap Select Css -->
    <link href="{{asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="clearfix" style="margin-bottom: 20px">
            <a href="{{route('admin.post')}}" style="float: left; padding: 8px 18px" class="badge bg-red">Back</a>
            @if($post->is_approved == true)
                <button type="button" class="btn btn-success pull-right" disabled>
                    <i class="material-icons">done</i>
                    <span>Approved</span>
                </button>
             @else
                <button type="button" class="btn btn-warning pull-right" onclick="approvePost()">
                    <i class="material-icons">done</i>
                    <span>Approve</span>
                </button>
                <form action="{{route('admin.post.approve',$post->id)}}" method="post" id="approve-post" style="display: none">
                    @csrf
                    @method('PUT')
                </form>
             @endif
        </div>
        <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>{{$post->title}} <small>Posted By <strong><a href="#">{{$post->user->name}}</a></strong> on {{$post->created_at->toFormattedDateString()}}</small></h2>
                        </div>
                        <div class="body">
                           {!! $post->body !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    {{-- category--}}
                    <div class="card">
                        <div class="header" style="background-color: #7ed871">
                            <h2>Categories</h2>
                        </div>
                        <div class="body">
                            @foreach($post->categories as $category)
                                <span class="badge bg-cyan">{{$category->name}}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="card">
                        <div class="header" style="background-color: #d8abad">
                            <h2>Categories</h2>
                        </div>
                        <div class="body">
                            @foreach($post->tags as $tag)
                                <span class="badge bg-cyan">{{$tag->name}}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="card">
                        <div class="header" style="background-color: #d8abad">
                            <h2>Feature Images</h2>
                        </div>
                        <div class="body">
                            <img src="{{asset('storage/post/'.$post->image)}}" alt="{{ Str::limit($post->title, 10)}}" width="100%" height="auto" style="object-fit: cover" class="img-responsive thumbnail">
                        </div>
                    </div>
                </div>
            </div>
        <!-- #END# Vertical Layout -->
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
        function approvePost() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to approve this post !!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    document.getElementById('approve-post').submit();
                }
            })
        }
    </script>
@endsection

