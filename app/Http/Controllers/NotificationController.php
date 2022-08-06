<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotification(){
//    dd(Notification::all());
        return    Notification::all();
    }
    public function readed($id){
        Notification::where('id', $id)->update([
              'isReading' => 1,]);
    }
}
