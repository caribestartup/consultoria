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

    public function show_training($id)
    {
        // $question = PlanQuestion::join('actions', 'actions.id', '=', 'plan_questions.action_id')
        //                 ->join('action_plans', 'action_plans.id', '=', 'actions.action_plan_id')
        //                 ->where(array('action_plans.id' => $id))
        //                 ->get();

        $actionPConfig = ActionPlanConfiguration::find($id);
        if($actionPConfig)
            // return view('action_plan.assigned.assigned', compact('actionPConfig'));
            return view('training.assigned.assigned', compact('actionPConfig'));
        else
            abort(404);

    }

    public function evaluation(Request $request, $id)
    {
        //recoger las respuesta y guardar en plan answer.
        $actionPConfig = ActionPlanConfiguration::find($id);
        // if($actionPConfig && $actionPConfig->users()->where('user_id', Auth::user()->id)->get()->first() != null) {
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
                                                'email'   => Auth::user()->email
                                            ]);
                                        }
                                    }
                                }else{
                                    $questionOption = PlanQuestionOption::where('id', $question['value'])->first();
                                    if ($questionOption) {
                                        DB::table('plan_answer_training')->insert([
                                            'plan_question_id' => $questionId,
                                            'action_configuration_id' => $actionId,
                                            'value' => $question['value'],
                                            'email'   => Auth::user()->email
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
                                'email'   => Auth::user()->email
                            ]);
                        }
                    }
                }
            }
        // }
        // else
        //     abort(404);
        //
        // return redirect(action('ActionPlanController@index'));

        //si rol es 'Evaluador' tomo id y elimino.

        //sino elimino notificacion.
        return redirect(action('ActionPlanController@index'));
    }
}
