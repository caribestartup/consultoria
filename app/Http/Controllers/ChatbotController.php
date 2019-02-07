<?php

namespace App\Http\Controllers;

use App\Chatbot;
use App\QuestionChatbot;
use App\AnswerChatbot;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->rol == "Administrador") {
            $chatbots = Chatbot::paginate(12);
            return view('chatbot.index', compact('chatbots'));
        }
        else {
            return view('error.403');
        }
    }

    public function next(Request $request)
    {
        $answer_id = $request->answer_id;
        $chatbot_id = $request->chatbot_id;
        $next = QuestionChatbot::join('chatbot_design', 'chatbot_design.question_id', '=', 'chatbot_questions.id')
                                ->where(array('chatbot_design.chatbot_id' => $chatbot_id, 'chatbot_design.trigger_answer_id' => $answer_id))
                                ->get();

        if(sizeof($next) > 0){
            $next_question = QuestionChatbot::find($next[0]->question_id);
            $next_answer = $next_question->answers;

            $next_data['question'] = $next_question;
            $next_data['answers'] = $next_answer;

            return $next_data;
        }
        else{
            $chat = DB::table('chatbot_user')
                        ->where('chatbot_user.chatbot_id', '=', $chatbot_id)
                        ->where('chatbot_user.user_id', '=', Auth::user()->id)
                        ->update(array('read' => true));
            return 0;
        }

    }

    public static function unread()
    {
        $chatbot = Chatbot::join('chatbot_user', 'chatbot_user.chatbot_id', '=', 'chatbots.id')
                        ->where('launch', '<=', date("Y-m-d"))
                        ->where('chatbot_user.read', '=', false)
                        ->where('chatbot_user.user_id', '=', Auth::user()->id)
                        ->where('chatbots.is_design', '=', true)
                        ->get();

        if(sizeof($chatbot) > 0){
            return Chatbot::find($chatbot[0]->chatbot_id);
        }
        else{
            return null;
        }
    }

    public function children($childrens, $id)
    {
        // recursividad para entrar las posiciones de las preguntas en el chatbot
        foreach ($childrens as $child) {
            if ($child["type"] == "answer" && sizeof($child) == 4) {
                if (isset($child["children"])){
                    DB::table('chatbot_design')
                        ->insert(
                            array('chatbot_id' => $id,
                                'question_id' => $child["children"][0]["id"],
                                'trigger_answer_id' => $child["db"]
                            )
                        );
                    $this->children($child["children"][0]["children"], $id);
                }
            }
        }

        return;
    }

    public function design_store(Request $request)
    {
        if (Auth::user()->rol == "Administrador") {
            $datas = $request->data;
            $id = $request->id;

            $oldDisegn = DB::table('chatbot_design')->where('chatbot_id', '=', $id)->get();

            if(!$oldDisegn->isEmpty()) {
                DB::table('chatbot_design')->where('chatbot_id', '=', $id)->delete();
            }

            foreach ($datas as $data) {
                if(isset($data["children"])){
                   $this->children($data["children"], $id);
                }
            }

            $chatbot = Chatbot::find($id);
            $chatbot_users = DB::table('chatbot_user')->where('chatbot_id', '=', $id)->get();
            if(isset($chatbot)){
                $chatbot->is_design = true;
                $chatbot->save();
            }
            if(!$chatbot_users->isEmpty()){
                foreach ($chatbot_users as $chatbot_user) {
                    DB::table('chatbot_user')->where('id', '=', $chatbot_user->id)->update(
                            array('read' => false)
                    );
                }
            }

            return;
        }
        else {
            return view('error.403');
        }
    }

    public function design($id)
    {
        if (Auth::user()->rol == "Administrador") {
            $questions = QuestionChatbot::where('chatbot_questions.chatbot_id', $id)->get();

            return view('chatbot.design', compact('questions'));
        }
        else {
            return view('error.403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->rol == "Administrador") {
            // $approachOptions = ['Plan de acción',  'Intereses', 'Microcontenidos', 'Grupos', 'Reuniones'];
            $approachOptions = ['Grupos'];

            return view('chatbot.create', compact('approachOptions'));
        }
        else {
            return view('error.403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->rol == "Administrador") {
            // $approachOptions = ['Plan de acción', 'Intereses', 'Microcontenidos', 'Grupos', 'Reuniones'];
            $approachOptions = ['Grupos'];
            $chatbot=Chatbot::find($id);
            if (isset($chatbot)) {
                return view('chatbot.create', compact('chatbot', 'approachOptions'));
            }
            else {
                return view('error.404');
            }
        }
        else {
            return view('error.403');
        }
    }

    public function show($id)
    {
        if (Auth::user()->rol == "Administrador") {
            //fetch post data
            $chatbot =  Chatbot::find($id);
            if (isset($chatbot)) {
                //pass posts data to view and load list view
                return view('chatbot.show', compact('chatbot','id'));
            }
            else {
                return view('error.404');
            }
        }
        else {
            return view('error.403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->rol == "Administrador") {
            $newChatbot = $this->processForm($request, $chatbot = new Chatbot());
            return redirect()->route('chatbot.index')->withSuccess(trans('app.success_store'));
        }
        else {
            return view('error.403');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->rol == "Administrador") {
            $chatbot = Chatbot::find($id);
            if(isset($chatbot)) {
                $this->processForm($request, $chatbot);
                return redirect()->route('chatbot.index')->with('success','Chatbot actualizado con éxito');
            }
            else
                return view('error.404');
        }
        else {
            return view('error.403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->rol == "Administrador") {
            $chatbot=  Chatbot::find($id);
            if (isset($chatbot)) {
                $chatbot->delete();
                return redirect()->route('chatbot.index')->with('success','Chatbot eliminado con éxito');
            }
            else {
                return view('error.404');
            }
        }
        else {
            return view('error.403');
        }
    }

    private function processForm(Request $request, $chatbot) {
        $chat = $request->chatbot;

        $chatbot->fill($chat);
        $chatbot->save();

        //Sinconizar grupos de usuario
        $userInsert = array();

        if(isset($request->groups)) {
            foreach ($request->groups as $group) {

                $insertGroup = DB::table('chatbot_group')->where(
                    array(
                        'chatbot_id' => $chatbot->id,
                        'group_id' => $group
                    )
                    )->get();

                if($insertGroup->isEmpty()) {

                    DB::table('chatbot_group')->insert(
                        [
                            'chatbot_id' => $chatbot->id,
                            'group_id' => $group
                        ]
                    );
                }

                $usuarios = DB::table('group_user')->where(array('group_id' => $group))->select('user_id')->get();

                if(!$usuarios->isEmpty()) {
                    foreach ($usuarios as $user) {
                        array_push($userInsert, $user->user_id);
                    }
                }

            }
        }
        else {
            $deleteGroup = DB::table('chatbot_group')->where(
                    array(
                        'chatbot_id' => $chatbot->id
                    )
                    )->get();

            if(!$deleteGroup->isEmpty()) {
                foreach ($deleteGroup as $value) {
                    DB::table('chatbot_group')->where(
                        [
                            'chatbot_group.id' => $value->id
                        ]
                    )->delete();
                }
            }
        }

        if(isset($request->users)) {
            foreach ($request->users as $user) {
                array_push($userInsert, $user);
            }
        }

        $resultado = array_unique($userInsert);

        //Sincronizo los usuarios
        $chatbot->users()->sync($resultado);

        //Envio notificaciones a los usuarios con esas acciones

        //Elimino las preguntas y respuestas a eliminar
        $toRemoveQuestions = $request->deleted['questions'];
        $toRemoveQuestions = explode(',', $toRemoveQuestions);
        if(count($toRemoveQuestions))
            QuestionChatbot::destroy($toRemoveQuestions);

        $toRemoveAnswers = $request->deleted['answers'];
        $toRemoveAnswers = explode(',', $toRemoveAnswers);
        if(count($toRemoveAnswers))
            AnswerChatbot::destroy($toRemoveAnswers);

        $questions = $request->question;
        $mCQuestions = $chatbot->questions;
        $questionCount = count($mCQuestions);
        if($questions) {
            foreach ($questions as $qKey => $data) {
                $data['chatbot_id'] = $chatbot->id;
                if($qKey < $questionCount) {
                    $question = $mCQuestions[$qKey];
                    $question->update($data);
                }
                else{
                    $question = QuestionChatbot::create($data);
                }

                $qAnswers = $question->answers;
                $answerCount = count($qAnswers);

                foreach ($data['answers'] as $key => $answerData) {

                    $answerData['question_chatbot_id'] = $question->id;

                    if($key < $answerCount) {
                        $answer = $qAnswers[$key];
                        $answer->update($answerData);
                    }else{
                        AnswerChatbot::create($answerData);
                    }
                }
            }
        }
    }
}
