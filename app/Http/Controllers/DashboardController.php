<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\User;
use App\MicroContent;
use App\Interest;
use App\ActionPlan;
use App\ActionPlanConfiguration;
use Illuminate\Support\Facades\DB;

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

        $results = DB::select('SELECT COUNT(coach_id) as amount, users.email from action_plan_configurations 
                            JOIN users on users.id = action_plan_configurations.coach_id GROUP BY coach_id');

        $coachs = '';
        $amounts = '';
        foreach ($results as $key => $value) {
            $coachs .= "'".$value->email."'".", ";
            $amounts .= $value->amount.", ";
        }

        // dd($coachs);
        return view('dashboard.index', compact('nUser', 'nMicroContent', 'nInterest', 'nActionPlan', 'coachs', 'amounts'));
    }
}
