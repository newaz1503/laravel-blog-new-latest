<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouritePostControler extends Controller
{
    public function favorite(){
        $posts = Auth::user()->favorite_posts;
        return view('admin.favorite', compact('posts'));
    }

    public function destroy($id){
        $post = Auth::user()->favorite_posts()->findOrFail($id);
        $post->delete();
        Toastr::success('Success', 'Favorite Post Deleted Successfully');
        return redirect()->back();
    }


}
