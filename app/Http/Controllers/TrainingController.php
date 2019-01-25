<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\PlanQuestionOption;
use App\PlanAnswer;
use App\PlanQuestion;
use App\Notification;
use App\ActionPlanConfiguration;
use Mail;

class TrainingController extends Controller
{

    public function show($id)
    {
        // $question = PlanQuestion::join('actions', 'actions.id', '=', 'plan_questions.action_id')
        //                 ->join('action_plans', 'action_plans.id', '=', 'actions.action_plan_id')
        //                 ->where(array('action_plans.id' => $id))
        //                 ->get();
        $actionPConfig = ActionPlanConfiguration::find($id);
        if($actionPConfig)
            return view('training.index', compact('actionPConfig'));
        else
            abort(404);
        // return view('training.index', compact('question'));
    }

    public function create(Request $request)
    {
        // return $request->all();

        $emails = mb_split(',', $request->emails);
        $id = $request->id;
        $url = '#';



        foreach ($emails as $email) {

            $exist_user = User::where(array('email' => $email))->get();
            if (sizeof($exist_user) > 0) {

                // sacarselo por una notificacion


            } else {

                // crear usuario nuevo
                $string = mb_split('@', $email);
                $name = $string[0];
                $pass = bcrypt($name);
                $rol = 'Evaluador';


                $dataUser = new User();
                $dataUser->name= $name;
                $dataUser->email = $email;
                $dataUser->password = $pass;
                $dataUser->rol = $rol;
                $dataUser->save();

                Mail::send('mail.index', ['email' => $email, 'name' => $name, 'url' => $url, 'id' => $id], function ($m) use ($email) {
                    $m->from('carmec634@gmail.com', 'Your Application');
                    $m->to($email)->subject('Evaluar entrenamiento!');
                });
            }
        }


    }

    public function FunctionName()
    {
        
    }

    public function evaluation(Request $request)
    {
        //recoger las respuesta y guardar en plan answer.


        //si rol es 'Evaluador' tomo id y elimino.

        //sino elimino notificacion.
    }
}
