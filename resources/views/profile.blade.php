@extends('layouts.frontend.master')

@section('title', 'Profile')

@section("css")
    <link href="{{asset('assets/frontend/category-sidebar/styles.css')}}" rel="stylesheet">

    <link href="{{asset('assets/frontend/category-sidebar/responsive.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="slider display-table center-text">
        <h1 class="title display-table-cell"><b>{{$author->name}}</b></h1>
    </div><!-- slider -->

    <section class="blog-area section">
        <div class="container">

            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="row">

                        @foreach($posts as $post)
                            <div class="col-lg-6 col-md-6">
                                <div class="card h-100">
                                    <div class="single-post post-style-1">

                            <div class="blog-image"><img src="{{asset('storage/post/'.$post->image)}}" alt="Blog Image"></div>
                                        

                                        <a class="avatar" href="{{route('post.author', $post->user->username)}}">
                                            <img src="{{asset('storage/profile/'.$post->user->image)}}" alt="Profile Image">

                                        </a>

                                        <div class="blog-info">

                                            <h4 class="title"><a href="{{route('post.details', $post->slug)}}"><b>{{$post->title}}</b></a></h4>

                                            <ul class="post-footer">
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
                                                <li><a href="#"><i class="ion-chatbubble"></i>{{$post->comments->count()}}</a></li>
                                                <li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
                                            </ul>

                                        </div><!-- blog-info -->
                                    </div><!-- single-post -->
                                </div><!-- card -->
                            </div><!-- col-lg-4 col-md-6 -->
                        @endforeach

                    </div><!-- row -->

                    <a class="load-more-btn" href="#"><b>LOAD MORE</b></a>

                </div><!-- col-lg-8 col-md-12 -->

                <div class="col-lg-4 col-md-12 ">

                    <div class="single-post info-area ">

                        <div class="about-area">
                            <h4 class="title"><b>ABOUT {{$author->name}}</b></h4>
                            <p>{{$author->about}}</p><br>
                            <p><strong>Author Name: </strong>{{$author->name}}</p>
                            <p><strong>Author Post: </strong> {{$post->count()}} </p>
                        </div>

                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- section -->
@endsection

@section("js")

@endsection

