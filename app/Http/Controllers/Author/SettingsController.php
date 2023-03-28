<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SettingsController extends Controller
{
    public function profile(){
        return view('author.profile');
    }

    public function profileUpdate(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);
        $image = $request->file('image');
        $slug = Str::slug($request->name);
        $profile = User::findOrFail(Auth::id());
        if(isset($image)){
            $current_time = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$current_time.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            //make category directory
            if (!Storage::disk('public')->exists('profile')){
                Storage::disk('public')->makeDirectory('profile');
            }
            if(Storage::disk('public')->exists('profile/'.$profile->image)){
                Storage::disk('public')->delete('profile/'.$profile->image);
            }
            $profileImage = Image::make($image)->resize(500, 500)->stream();
            Storage::disk('public')->put('profile/'.$imageName,$profileImage);
        }else{
            $imageName = $profile->image;
        }
        $profile->name = $request->name;
        $profile->email = $request->email;
        $profile->image = $imageName;
        $profile->about = $request->about;
        $profile->save();
        Toastr::success('Success', 'profile Updated Successfully');
        return redirect()->back();
    }

    public function UpdatePassword(Request $request){
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        $OldHashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password, $OldHashedPassword)){
            $user = User::findOrFail(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            Toastr::success('Success', 'Password Updated Successfully');
            Auth::logout();
            return redirect()->back();
        }else{
            Toastr::error('Error', 'Password does not match');
            return redirect()->back();
        }
    }
}
