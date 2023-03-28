<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function subscriber(Request $request){
        $this->validate($request, [
           'email' => 'required|unique:subscribers'
        ]);
        $subscribe = new Subscriber();
        $subscribe->email = $request->email;
        $subscribe->save();
        Toastr::success('Success', 'You have been subscribed');
        return redirect()->back();
    }
}
