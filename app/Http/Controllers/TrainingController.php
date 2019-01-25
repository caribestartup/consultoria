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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Action;
use App\ActionConfiguration;
use App\ActionPlan;
use App\FreeContent;
use App\Image;
use App\MicroContent;
use App\UserMicroContent;
use App\Question;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Hash;

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
            return view( 'error.404');
    }

    public function create(Request $request)
    {
        $emails = mb_split(',', $request->emails);
        $id = $request->id;
        $url = '/training/create/'.$id;

        foreach ($emails as $email) {

            $exist_user = User::where(array('email' => $email))->get();
            if (sizeof($exist_user) > 0) {

                // sacarselo por una notificacion
                Mail::send('mail.index', ['email' => $email, 'name' => $name, 'url' => $url], function ($m) use ($email) {
                    $m->from('carmec634@gmail.com', 'Your Application');
                    $m->to($email)->subject('Evaluar entrenamiento!');
                });


            } else {

                // crear usuario nuevo
                $string = mb_split('@', $email);
                $name = $string[0];
                $pass = $name;
                $rol = 'Evaluador';


                // $dataUser = new User();
                $dataUser = array();
                $dataUser['name']= $name;
                $dataUser['email'] = $email;
                $dataUser['password'] = $pass;
                $dataUser['rol'] = $rol;
                // $dataUser->save();
                $user = User::create($dataUser);

                Mail::send('mail.index', ['email' => $email, 'name' => $name, 'url' => $url], function ($m) use ($email) {
                    $m->from('carmec634@gmail.com', 'Your Application');
                    $m->to($email)->subject('Evaluar entrenamiento!');
                });
            }
        }


    }

    public function show_training($id)
    {

        $actionPConfig = ActionPlanConfiguration::find($id);
        if($actionPConfig)
            return view('training.assigned.assigned', compact('actionPConfig'));
        else
            return view( 'error.404');

    }

    public function evaluation(Request $request, $id)
    {
        //recoger las respuesta y guardar en plan answer training.
        $actionPConfig = ActionPlanConfiguration::find($id);
            $actions = $request->action;
            foreach ($actions as $actionId => $action) {
                $actionConfig = ActionConfiguration::find($actionId);
                $actionConfig->fill($action);
                $actionConfig->save();

                $questions = $action['question'];
                foreach ($questions as $questionId => $question) {
                    $questionO = $actionConfig->action->questions()->where('id', $questionId)->get()->first();
                    if($questionO) {
                        DB::table('plan_answer_training')->where('email', Auth::user()->email)
                            ->where('action_configuration_id', $actionId)
                            ->where('plan_question_id', $questionId)->delete();

                        if($questionO->type == PlanQuestion::SINGLE ||
                            $questionO->type == PlanQuestion::MULTIPLE) {
                            $questionOptions = $questionO->options()->where('id', $questionId)->get();
                            if($questionOptions != null) {


                                if(is_array($question['value'])) {
                                    foreach ($question['value'] as $value) {
                                        $questionOption = PlanQuestionOption::where('id', $value)->first();
                                        if ($questionOption) {
                                            DB::table('plan_answer_training')->insert([
                                                'plan_question_id' => $questionId,
                                                'action_configuration_id' => $actionId,
                                                'value' => $questionOption->id,
                                                'email'   => Auth::user()->email,
                                                'created_at' => date("Y-m-d H:i:s")
                                            ]);
                                        }
                                    }
                                }
                                else{
                                    $questionOption = PlanQuestionOption::where('id', $question['value'])->first();
                                    if ($questionOption) {
                                        DB::table('plan_answer_training')->insert([
                                            'plan_question_id' => $questionId,
                                            'action_configuration_id' => $actionId,
                                            'value' => $question['value'],
                                            'email'   => Auth::user()->email,
                                            'created_at' => date("Y-m-d H:i:s")
                                        ]);
                                    }
                                }
                            }
                        }
                        else{
                            DB::table('plan_answer_training')->insert([
                                'plan_question_id' => $questionId,
                                'action_configuration_id' => $actionId,
                                'value' => $question['value'],
                                'email'   => Auth::user()->email,
                                'created_at' => date("Y-m-d H:i:s")
                            ]);
                        }
                    }
                }
            }

        if (Auth::user()->rol == 'Evaluador') {

            //si rol es 'Evaluador' tomo id y elimino.
            $userEvaduador = User::findOrFail(Auth::user()->id);
            $userEvaduador->delete();
            // return redirect(action('\App\Http\Controllers\Auth\LoginController@logout'));

            return redirect()->route('logout')->withSuccess('Evaluación realizada con éxito');
        }

        return redirect()->route('action_plans.index')->withSuccess('Evaluación del estrenamiento realizada con éxito');
    }
}
