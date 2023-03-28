<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function All_post(){
        $posts = Post::latest()->approved()->Status()->paginate(9);
        return view('all-post', compact('posts'));
    }

    public function post_details($slug){
        $post = Post::where('slug', $slug)->first();
        $key = 'blog-'.$post->id;
        if (!Session::has($key)){
            $post->increment('view_count');
            Session::put($key, 1);
        }
        $randomPost = Post::approved()->Status()->take(3)->inRandomOrder();
        return view('post_details', compact('post', 'randomPost'));
    }

    public function category_post($slug){
        $category = Category::where('slug', $slug)->first();
        $posts = $category->posts()->approved()->Status()->get();
        return view('category_post', compact('category','posts'));
    }

    public function tag_post($slug){
        $tag = Tag::where('slug', $slug)->first();
        $posts = $tag->posts()->approved()->Status()->get();
        return view('tag_post', compact('tag', 'posts'));
    }


}
