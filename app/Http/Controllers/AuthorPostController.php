<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthorPostController extends Controller
{
    public function author_post($username){
        $author = User::where('username', $username)->first();
        $posts = $author->posts()->approved()->Status()->get();
        return view('profile', compact('author','posts'));
    }
}
