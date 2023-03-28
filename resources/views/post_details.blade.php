@extends('layouts.frontend.master')

@section('title')
    {{$post->title}}
@endsection

@section("css")
    <link href="{{asset('assets/frontend/post-details/styles.css')}}" rel="stylesheet">

    <link href="{{asset('assets/frontend/post-details/responsive.css')}}" rel="stylesheet">
    <style>
        .active{
            color: blue;
        }
        .header-bg{
            width: 100%;
            height: 400px;
            background-image: url("{{asset('storage/post/'.$post->image)}}");
            background-size: cover;
        }
    </style>
@endsection

@section('content')
    <div class="header-bg">

    </div><!-- slider -->

    <section class="post-area section">
        <div class="container">

            <div class="row">

                <div class="col-lg-8 col-md-12 no-right-padding">

                    <div class="main-post">

                        <div class="blog-post-inner">

                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="#">
                                        <img src="{{asset('storage/profile/'.$post->user->image)}}" alt="Profile Image">

                                    </a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="#"><b>{{$post->user->name}}</b></a>
                                    <h6 class="date"> on {{$post->created_at->diffForHumans()}}</h6>
                                </div>

                            </div><!-- post-info -->

                            <h3 class="title"><a href="#"><b>{{$post->title}}</b></a></h3>

                            <p class="para">
                                {!! html_entity_decode($post->body) !!}
                            </p>

                            <ul class="tags">
                                @foreach($post->categories as $category)
                                    <li><a href="{{route('category.post', $category->slug)}}">{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </div><!-- blog-post-inner -->

                        <div class="post-icons-area">
                            <ul class="post-icons">
                                <li>
                                    @guest
                                        <a href="javascript:void(0);" onclick="toastr.info('You need to login first', 'Info', {
                                                progressBar: true,
                                                closeButton: true,
                                            }) "><i class="ion-heart"></i>{{$post->favorite_to_users->count()}}</a>
                                    @else
                                        <a href="javascript:void(0);" onclick="document.getElementById('favorite-post-{{$post->id}}').submit();"
                                           class="{{Auth::user()->favorite_posts->where('pivot.post_id', $post->id)->count()? 'active' : '' }}"
                                        ><i class="ion-heart"></i>{{$post->favorite_to_users->count()}}</a>
                                        <form id="favorite-post-{{$post->id}}" action="{{route('favorite.post', $post->id)}}" method="post">
                                            @csrf
                                        </form>
                                    @endguest

                                </li>
                                <li><a href="#"><i class="ion-chatbubble"></i>6</a></li>
                                <li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
                            </ul>

                            <ul class="icons">
                                <li>SHARE : </li>
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
                            </ul>
                        </div>
                    </div><!-- main-post -->
                </div><!-- col-lg-8 col-md-12 -->

                <div class="col-lg-4 col-md-12 no-left-padding">

                    <div class="single-post info-area">

                        <div class="sidebar-area about-area">
                            <h4 class="title"><b>ABOUT AUTHOR</b></h4>
                            <p>{{$post->user->about}}</p>
                        </div>

                        <div class="tag-area">

                            <h4 class="title"><b>TAG CLOUD</b></h4>
                            <ul>
                                @foreach($post->tags as $tag)
                                     <li><a href="{{route('tag.post', $tag->slug)}}">{{$tag->name}}</a></li>
                                 @endforeach
                            </ul>

                        </div><!-- subscribe-area -->

                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- post-area -->


    <section class="recomended-area section">
        <div class="container">
            <div class="row">

                @foreach($randomPost as $random)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{asset(Storage::disk('public')->url('post/'.$random->image))}}" alt="Blog Image"></div>

                                <a class="avatar" href="{{route('post.author', $random->user->username)}}"><img src="{{asset(Storage::disk('public')->url('profile/'.$random->user->image))}}" alt="Profile Image"></a>

                                <div class="blog-info">

                                    <h4 class="title"><a href="{{route('post.details', $random->slug)}}"><b>{{$random->title}}</b></a></h4>

                                    <ul class="post-footer">
                                        <li>
                                            @guest
                                                <a href="javascript:void(0);" onclick="toastr.info('You need to login first', 'Info', {
                                                progressBar: true,
                                                closeButton: true,
                                            }) "><i class="ion-heart"></i>{{$random->favorite_to_users->count()}}</a>
                                            @else
                                                <a href="javascript:void(0);" onclick="document.getElementById('favorite-post-{{$random->id}}').submit();"
                                                   class="{{Auth::user()->favorite_posts->where('pivot.post_id', $random->id)->count()? 'active' : '' }}"
                                                ><i class="ion-heart"></i>{{$random->favorite_to_users->count()}}</a>
                                                <form id="favorite-post-{{$random->id}}" action="{{route('favorite.post', $random->id)}}" method="post">
                                                    @csrf
                                                </form>
                                            @endguest

                                        </li>
                                        <li><a href="#"><i class="ion-chatbubble"></i>{{$post->comments->count()}}</a></li>
                                        <li><a href="#"><i class="ion-eye"></i>{{$random->view_count}}</a></li>
                                    </ul>

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
                @endforeach

            </div><!-- row -->

        </div><!-- container -->
    </section>

    <section class="comment-section">
        <div class="container">
            <h4><b>POST COMMENT</b></h4>
            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="comment-form">
                       @guest
                           <p>For Comment, You need to login first <a href="{{route('login')}}">Login</a> </p>
                        @else
                            <form method="post" action="{{route('comment', $post->id)}}" method="post" >
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
									<textarea name="comment" rows="2" class="text-area-messge form-control"
                                              placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
                                    </div><!-- col-sm-12 -->
                                    <div class="col-sm-12">
                                        <button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
                                    </div><!-- col-sm-12 -->

                                </div><!-- row -->
                            </form>
                        @endguest
                    </div><!-- comment-form -->

                    <h4><b>COMMENTS({{$post->comments->count()}})</b></h4>

                    @if($post->comments->count() > 0)
                        @foreach($post->comments as $comment)
                            <div class="commnets-area ">

                            <div class="comment">

                                <div class="post-info">

                                    <div class="left-area">
                                        <a class="avatar" href="#"><img src="{{Storage::disk('public')->url('profile/'.$comment->user->image)}}" alt="Profile Image"></a>
                                    </div>

                                    <div class="middle-area">
                                        <a class="name" href="#"><b>{{$comment->user->name}}</b></a>
                                        <h6 class="date">on {{$comment->created_at->diffForHumans()}}</h6>
                                    </div>

                                </div><!-- post-info -->

                                <p>{{$comment->comment}}</p>

                            </div>

                        </div><!-- commnets-area -->
                        @endforeach
                    @else
                        <div class="commnets-area ">
                            <div class="comment">
                                <p>No comment found</p>
                            </div>
                        </div><!-- commnets-area -->

                    @endif


                    <a class="more-comment-btn" href="#"><b>VIEW MORE COMMENTS</a>

                </div><!-- col-lg-8 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section>
@endsection

@section("js")

@endsection

