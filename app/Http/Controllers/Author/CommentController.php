<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function comment(){
        $posts = Auth::user()->posts;
        return view('author.comment',compact('posts'));
    }

    public function destroy($id){
        $comment = Comment::findOrFail($id);
        if ($comment->post->user->id == Auth::id()){
            $comment->delete();
            Toastr::success('Success', 'Comment Deleted Successfully');
        }else{
            Toastr::error('Error', 'Something went wrong');
        }

        return redirect()->back();
    }
}
