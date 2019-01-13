<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
//    public function __construct()
//    {
////        var_dump("dashboard");
////        var_dump(Config::get('database.default'));die;
//        if(Session::has('selected.database'))
//        {
//            Config::set('database.default',Session::get('selected.database'));
//        }
//    }

    public function index()
    {
        return view('dashboard.index');
    }
}
