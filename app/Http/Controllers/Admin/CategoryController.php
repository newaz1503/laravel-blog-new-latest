<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|unique:categories',
            // 'image' => 'required|mimes:jpeg, png, bnp,gif, jpeg'
        ]);
        $image = $request->file('image');
        $slug = Str::slug($request->name);
        if(isset($image)){
            $current_time = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$current_time.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //make category directory
            if (!Storage::disk('public')->exists('category')){
                Storage::disk('public')->makeDirectory('category');
            }
            $category = Image::make($image)->resize(1600, 479)->stream();
            Storage::disk('public')->put('category/'.$imageName,$category);
            //make slider directory
            if (!Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->makeDirectory('category/slider');
            }
            $slider = Image::make($image)->resize(500, 333)->stream();
            Storage::disk('public')->put('category/slider/'.$imageName,$slider);
        }else{
            $imageName = 'default.jpg';
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imageName;
        $category->save();
        Toastr::success('Success', 'Category Created Successfully');
        return redirect()->route('admin.category');
    }

    public function edit($id){
        $category = Category::findOrFail($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'image' => 'mimes:jpeg, png, bnp,gif, jpeg'
        ]);
        $category = Category::findOrFail($id);
        $image = $request->file('image');
        $slug = Str::slug($request->name);
        if(isset($image)){
            $current_time = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$current_time.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //make category directory
            if (!Storage::disk('public')->exists('category')){
                Storage::disk('public')->makeDirectory('category');
            }
            if(Storage::disk('public')->exists('category/'.$category->image)){
                Storage::disk('public')->delete('category/'.$category->image);
            }
            $category_image = Image::make($image)->resize(1600, 479)->stream();
            Storage::disk('public')->put('category/'.$imageName,$category_image);


            //make slider directory
            if (!Storage::disk('public')->exists('category/slider')){
                Storage::disk('public')->makeDirectory('category/slider');
            }
            if(Storage::disk('public')->exists('category/slider/'.$category->image)){
                Storage::disk('public')->delete('category/slider/'.$category->image);
            }
            $slider = Image::make($image)->resize(500, 333)->stream();
            Storage::disk('public')->put('category/slider/'.$imageName,$slider);
        }else{
            $imageName = $category->image;
        }

        $category->name = $request->name;
        $category->slug = $slug;
        $category->image = $imageName;
        $category->save();
        Toastr::success('Success', 'Category Created Successfully');
        return redirect()->route('admin.category');
    }

    public function destroy($id){
        $category = Category::findOrFail($id);
        if(Storage::disk('public')->exists('category/'.$category->image)){
            Storage::disk('public')->delete('category/'.$category->image);
        }
        if(Storage::disk('public')->exists('category/slider/'.$category->image)){
            Storage::disk('public')->delete('category/slider/'.$category->image);
        }
        $category->delete();
        Toastr::success('Success', 'Category Deleted Successfully');
        return redirect()->back();
    }
}
