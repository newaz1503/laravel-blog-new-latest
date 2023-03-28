<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index(){
        $tags = Tag::latest()->get();
        return view('admin.tag.index', compact('tags'));
    }

    public function create(){
        return view('admin.tag.create');
    }

    public function store(Request $request){
        $this->validate($request, [
           'name' => 'required'
        ]);
        $tag = new Tag();
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name);
        $tag->save();
        Toastr::success('Success', 'Tag Created Successfully');
        return redirect()->route('admin.tag');
    }

    public function edit($id){
        $tag = Tag::findOrFail($id);
        return view('admin.tag.edit', compact('tag'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required'
        ]);
        $tag = Tag::findOrFail($id);
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->name);
        $tag->save();
        Toastr::success('Success', 'Tag Updated Successfully');
        return redirect()->route('admin.tag');
    }

    public function destroy($id){
        $tag = Tag::findOrFail($id);
        $tag->delete();
        Toastr::success('Success', 'Tag Deleted Successfully');
        return redirect()->back();
    }


}
