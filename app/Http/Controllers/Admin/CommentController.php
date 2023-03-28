<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(){
        $comments = Comment::latest()->get();
        return view('admin.comment',compact('comments'));
    }

    public function destroy($id){
        $comment = Comment::findOrFail($id);
        $comment->delete();
        Toastr::success('Success', 'Comment Deleted Successfully');
        return redirect()->back();
    }





}
