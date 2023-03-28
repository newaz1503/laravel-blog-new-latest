<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Tag;
use App\Notifications\AdminNotifyToAuthor;
use App\Notifications\NotifyToSubscriber;
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
        $posts = Post::latest()->get();
        return view('admin.post.index', compact('posts'));
    }

    public function create(){
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.create',compact('categories', 'tags'));
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
        $post->is_approved = true;
        $post->save();
        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);
        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber){
            Notification::route('mail', $subscriber->email)
                ->notify(new NotifyToSubscriber($post));
        }
        Toastr::success('Success', 'Post Created Successfully');
        return redirect()->route('admin.post');
    }

    public function edit($id){
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.edit', compact('post','categories','tags'));
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
        $post->is_approved = true;
        $post->save();

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);
        Toastr::success('Success', 'Post Updated Successfully');
        return redirect()->route('admin.post');
    }

    public function destroy($id){
        $post = Post::findOrFail($id);
        if(Storage::disk('public')->exists('post/'.$post->image)){
            Storage::disk('public')->delete('post/'.$post->image);
        }
        $post->categories()->detach();
        $post->tags()->detach();
        $post->delete();
        Toastr::success('Success', 'Post Deleted Successfully');
        return redirect()->route('admin.post');
    }

    public function show($id){
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.show', compact('post', 'categories', 'tags'));
    }

    public function pending(){
        $posts = Post::where('is_approved', 0)->get();
        return view('admin.post.pending', compact('posts'));
    }

    public function approve($id){
        $post = Post::findOrFail($id);
        if ($post->is_approved == false){
            $post->is_approved = true;
            $post->save();
            $post->user->notify(new AdminNotifyToAuthor($post));
            $subscribers = Subscriber::all();
            foreach ($subscribers as $subscriber){
                Notification::route('mail', $subscriber->email)
                    ->notify(new NotifyToSubscriber($post));
            }
            Toastr::success('Success', 'Post Approved Successfully');
            return redirect()->route('admin.post.pending');
        }else{
            Toastr::success('Info', 'Post Already Approved Successfully');
            return redirect()->route('admin.post');
        }
    }


}
