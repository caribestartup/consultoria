<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public static function unread(){
        return Notification::where('read', true)->where('user_id', Auth::user()->id)->get();
    }

    public function destroy($id)
    {
        $notificacion = Notification::findOrFail($id);
        if ($notificacion->user_id == Auth::user()->id) {
            $microContentUser = DB::table('micro_content_user')
                        ->where('micro_content_user.user_id', $notificacion->entity_id)
                        ->where('micro_content_user.micro_content_id', $notificacion->micro_content_id)
                        ->first();

             $answerUserQuestion = DB::table('micro_contents')
                 ->join('questions', 'micro_contents.id', '=', 'questions.micro_content_id')
                 ->join('answers', 'questions.id', '=', 'answers.question_id')
                 ->join('answer_user_question', 'answers.id', '=', 'answer_user_question.answer_id')
                 ->where('micro_contents.id', $microContentUser->micro_content_id)
                 ->where('answer_user_question.user_id', $notificacion->entity_id)
                 ->select('answer_user_question.id')
                 ->get();

            //ver
            // $actionPlanConfigurationContent = DB::table('micros_contents')
            //     ->join('action_micro_content', 'action_micro_content.micro_content_id', '=', 'micro_contents.id')
            //     ->join('actions', 'actions.id', '=', 'action_micro_content.action_id')
            //     ->join('action_plan_configuration_user', 'action_plan_configuration_user.action_plan_configuration_id', '=', 'actions.id')
            //     ->where('action_plan_configuration_user.user_id', Auth::user()->id)
            //     ->where('micro_contents', $microContentUser->micro_content_id)
            //     ->select('action_plan_configuration_user.action_plan_configuration_id')
            //     ->get();

             $microContentUser = DB::table('micro_content_user')
                         ->where('micro_content_user.user_id', $notificacion->entity_id)
                         ->where('micro_content_user.micro_content_id', $notificacion->micro_content_id)
                         ->delete();

             foreach ($answerUserQuestion as $value) {
                 DB::table('answer_user_question')->where('id', $value->id)->delete();
             }

             $notificacion->type = 'removed';
             $notificacion->read = 0;
             $notificacion->save();

             return redirect('/')->withSuccess('eliminado');
        }
        else {
            return view('error.404');
        }
    }

    public function show($id)
    {
        $notificacion = Notification::findOrFail($id);

        // notificacion
        // $notification = new Notification();
        // $notification->user_id = $coach[0]->coach_id;
        // $notification->entity_id = $user_id;
        // $notification->entity_type = User::class;
        // $notification->micro_content_id = $microContent->id;
        // $notification->type = Notification::NEW;
        // $notification->save();

        if ($notificacion->user_id == Auth::user()->id) {
            $microContentUser = DB::table('micro_content_user')
                        ->where('micro_content_user.user_id', $notificacion->entity_id)
                        ->where('micro_content_user.micro_content_id', $notificacion->micro_content_id)
                        ->first();

             $answerUserQuestion = DB::table('micro_contents')
                 ->join('questions', 'micro_contents.id', '=', 'questions.micro_content_id')
                 ->join('answers', 'questions.id', '=', 'answers.question_id')
                 ->join('answer_user_question', 'answers.id', '=', 'answer_user_question.answer_id')
                 ->where('micro_contents.id', $microContentUser->micro_content_id)
                 ->where('answer_user_question.user_id', $notificacion->entity_id)
                 ->select('answer_user_question.id')
                 ->get();

             $microContentUser = DB::table('micro_content_user')
                         ->where('micro_content_user.user_id', $notificacion->entity_id)
                         ->where('micro_content_user.micro_content_id', $notificacion->micro_content_id)
                         ->update(array('approve'=> false, 'nota'=> 0, 'doit'=> false));

             foreach ($answerUserQuestion as $value) {
                 DB::table('answer_user_question')->where('id', $value->id)->delete();
             }

             $notificacion->type = 'removed';
             $notificacion->read = 0;
             $notificacion->save();

             return redirect('/')->withSuccess('eliminado');
        }
        else {
            return view('error.404');
        }
    }

    public function update($id)
    {
        $notificacion = Notification::findOrFail($id);
        if ($notificacion->user_id == Auth::user()->id) {

            $notificacion->type = 'update';
            $notificacion->read = 0;
            $notificacion->save();

            $microContentUser = DB::table('micro_content_user')
                        ->where('micro_content_user.user_id', $notificacion->entity_id)
                        ->where('micro_content_user.micro_content_id', $notificacion->micro_content_id)
                        ->update(array('approve_coach'=> true));


            return redirect('/')->withSuccess('Actuaizado el estudiante');
        }
        else {
            return view('error.404');
        }
    }

}
