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

    public function index()
    {
        $nUser = User::all()->count();
        $nMicroContent = MicroContent::all()->count();
        $nInterest = Interest::all()->count();
        $nActionPlan = ActionPlan::all()->count();

        $list_coachs = User::where(array('is_coach' => true))->get();

        $coachs = '';
        $dataResult['terminados'] = '';
        $dataResult['sinComerzar'] = '';
        $dataResult['sinTerminar'] = '';

        foreach ($list_coachs as $coach) {

            $coachs .= "'".$coach->email."'".", ";

            $terminados = 0;
            $sinTerminar = 0;
            $sinComerzar = 0;
            $aPlanConfs = ActionPlanConfiguration::where(array('coach_id' => $coach->id))->get(); // me da todos los planes de accion de por coach

            foreach ($aPlanConfs as $aPlanConf) {   //  recorro los planes de accion para ver por empleado los resultados

                // cojo todos los usuarios de ese plan de accion
                $usuarios = DB::table('action_plan_configuration_user')
                                ->join('action_plan_configurations', 'action_plan_configurations.id', '=', 'action_plan_configuration_user.action_plan_configuration_id')
                                ->where(array('action_plan_configurations.id'=> $aPlanConf->id))
                                ->select('action_plan_configuration_user.user_id')
                                ->get();

                //variables para comparar cual de los estados se debe incrementar
                $nTerminados = 0;
                $nSinTerminar = 0;
                $nSinComerzar = 0;
                foreach ($usuarios as $key => $usuario) {
                    // recorro los resultados de los usuarios por cada plan de accion
                    $results = $aPlanConf->user_compliment($usuario->user_id);

                    if($results == 100) {
                        $nTerminados++;
                    } else if ($results == 0) {
                        $nSinComerzar++;
                    } else {
                        $nSinTerminar++;
                    }
                }

                if(sizeof($usuarios) == $nTerminados) {
                    $terminados++;
                } else if (sizeof($usuarios) == $nSinComerzar) {
                    $sinComerzar++;
                } else {
                    $sinTerminar++;
                }
            }
            $dataResult['terminados'] .= $terminados.", ";
            $dataResult['sinComerzar'] .= $sinComerzar.", ";
            $dataResult['sinTerminar'] .= $sinTerminar.", ";
        }

        return view('dashboard.index', compact('nUser', 'nMicroContent', 'nInterest', 'nActionPlan', 'coachs', 'dataResult'));
    }
}
