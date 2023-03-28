<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavouritePostControler extends Controller
{
    public function favorite(Request $request, $id){
        $favorite_post = Auth::user()->favorite_posts()->where('post_id', $id)->count();
        if ($favorite_post == 0){
            Auth::user()->favorite_posts()->attach($id);
            Toastr::success('Success', 'You post successfully added by your favorite list');
            return redirect()->back();
        }else{
            Auth::user()->favorite_posts()->detach($id);
            Toastr::success('Success', 'You post successfully removed by your favorite list');
            return redirect()->back();
        }
    }
}
