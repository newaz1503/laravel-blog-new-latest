<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\AuthorNotifyToAdmin;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function index(){
        $posts = Auth::user()->posts()->latest()->get();
        return view('author.post.index', compact('posts'));
    }

    public function create(){
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.create',compact('categories', 'tags'));
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png,bnp,gif',
            'categories' => 'required',
            'tags' => 'required',
            'description' => 'required',
        ]);
        $image = $request->file('image');
        $slug = Str::slug($request->title);
        if(isset($image)){
            $current_time = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$current_time.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //make category directory
            if (!Storage::disk('public')->exists('post')){
                Storage::disk('public')->makeDirectory('post');
            }
            $post = Image::make($image)->resize(1600, 479)->stream();
            Storage::disk('public')->put('post/'.$imageName,$post);

        }else{
            $imageName = 'default.jpg';
        }

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->description;
        if (isset($request->status)){
            $post->status = true;
        }else{
            $post->status = false;
        }
        $post->is_approved = false;
        $post->save();
        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);

        $users = User::where('role_id', '1')->get();
        Notification::send($users, new AuthorNotifyToAdmin($post));

        Toastr::success('Success', 'Post Created Successfully');
        return redirect()->route('author.post');
    }

    public function edit($id){
        $post = Post::findOrFail($id);
        if ($post->user_id != Auth::id()){
            Toastr::error('Error', 'Something went wrong');
            return redirect()->back();
        }
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.edit', compact('post','categories','tags'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'title' => 'required',
            'image' => 'mimes:jpeg, jpg, png, bnp, gif',
            'categories' => 'required',
            'tags' => 'required',
            'description' => 'required',
        ]);
        $post = Post::findOrFail($id);
        if ($post->user_id != Auth::id()){
            Toastr::error('Error', 'Something went wrong');
            return redirect()->back();
        }
        $image = $request->file('image');
        $slug = Str::slug($request->title);
        if(isset($image)){
            $current_time = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$current_time.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //make category directory
            if (!Storage::disk('public')->exists('post')){
                Storage::disk('public')->makeDirectory('post');
            }
            if (Storage::disk('public')->exists('post/'.$post->image)){
                Storage::disk('public')->delete('post/'.$post->image);
            }
            $postImage = Image::make($image)->resize(1600, 479)->stream();
            Storage::disk('public')->put('post/'.$imageName,$postImage);

        }else{
            $imageName = $post->image;
        }

        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imageName;
        $post->body = $request->description;
        if (isset($request->status)){
            $post->status = true;
        }else{
            $post->status = false;
        }
        $post->is_approved = false;
        $post->save();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);
        Toastr::success('Success', 'Post Updated Successfully');
        return redirect()->route('author.post');
    }

    public function destroy($id){
        $post = Post::findOrFail($id);
        if ($post->user_id != Auth::id()){
            Toastr::error('Error', 'Something went wrong');
            return redirect()->back();
        }
        if(Storage::disk('public')->exists('post/'.$post->image)){
            Storage::disk('public')->delete('post/'.$post->image);
        }
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        Toastr::success('Success', 'Post Deleted Successfully');
        return redirect()->route('author.post');
    }

    public function show($id){
        $post = Post::findOrFail($id);
        if ($post->user_id != Auth::id()){
            Toastr::error('Error', 'Something went wrong');
            return redirect()->back();
        }
        $categories = Category::all();
        $tags = Tag::all();
        return view('author.post.show', compact('post', 'categories', 'tags'));
    }


}
