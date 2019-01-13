<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public static function unread(){
        return Notification::where('read', true)->where('user_id', Auth::user()->id)->get();
    }
}
