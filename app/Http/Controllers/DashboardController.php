<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\User;
use App\MicroContent;
use App\Interest;
use App\ActionPlan;

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
        $nUser = User::all()->count();
        $nMicroContent = MicroContent::all()->count();
        $nInterest = Interest::all()->count();
        $nActionPlan = ActionPlan::all()->count();

        return view('dashboard.index', compact('nUser', 'nMicroContent', 'nInterest', 'nActionPlan'));
    }
}
