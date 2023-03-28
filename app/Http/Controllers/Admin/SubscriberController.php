<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function subscriber(){
        $subscribers = Subscriber::latest()->get();
        return view('admin.subscriber', compact('subscribers'));
    }

    public function destroy($id){
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();
        Toastr::success('Success', 'Subscriber Deleted Successfully');
        return redirect()->back();

    }

}
