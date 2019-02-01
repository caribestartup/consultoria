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
        $chatbots = Chatbot::all();
        return view('chatbot.index', compact('chatbots'));

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
                        ->get();

    
        
        
        if(sizeof($chatbot) > 0){
            return Chatbot::find($chatbot[0]->chatbot_id);
        }
        else{
            return null;
        }
        // dd($chatbot);
    }

    public function children($childrens, $id)
    {
        foreach ($childrens as $child) {
            if ($child["type"] == "answer" && sizeof($child) == 4) {
                if (isset($child["children"])){
                    // return $child["children"][0];
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
        $datas = $request->data;
        $id = $request->id;
        // return $id;
        foreach ($datas as $data) {
            if(isset($data["children"])){
               $this->children($data["children"], $id);
            }
        }
        return;
    }

    // public function design_store(Request $request)
    // {
    //     $datas = $request->data;
    //     // $id = $request->id;
        
    //     foreach ($datas as $data) {
    //         return $data;
    //         $insert = $data;
    //         if(isset($data->children)){
    //             foreach ($data->children as $child) {
    //                 if(isset($child)){
                        
    //                 }
    //             }
    //            $insert = $this->children($data->children, 2);
    //         }
    //     }
    // }

    public function design($id)
    {
        $questions = QuestionChatbot::where('chatbot_questions.chatbot_id', $id)->get();
        // dd($questions);
        return view('chatbot.design', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $approachOptions = ['Plan de acción',  'Intereses', 'Microcontenidos', 'Grupos', 'Reuniones'];
        $approachOptions = ['Grupos'];
        return view('chatbot.create', compact('approachOptions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $approachOptions = ['Plan de acción', 'Intereses', 'Microcontenidos', 'Grupos', 'Reuniones'];
        $approachOptions = ['Grupos'];
        $chatbot=Chatbot::find($id);
        // return view('chatbot.edit', compact('chatbot','id', 'approachOptions'));
        return view('chatbot.create', compact('chatbot', 'approachOptions'));
    }

    public function show($id)
    {
        //fetch post data
        $chatbot =  Chatbot::find($id);
        //pass posts data to view and load list view
        return view('chatbot.show', compact('chatbot','id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request['chatbot']);
        // $this->validate($request['chatbot'], [
        //     'name' => 'required',
        //     'description' => 'required',
        //     'approach' => 'required'
        // ]);


        //$chatbot =  new chatbot();
        //$chatbot->name=$request->get('name');
        //$chatbot->description=$request->get('description');
        //$chatbot->approach=$request->get('approach');
        //$chatbot->default_response=$request->get('default_response');

        //$chatbot->save();

        //return redirect()->route('chatbot.index')->withSuccess(trans('app.success_store'));
//        return back()->withSuccess(trans('app.success_store'));

        if (Auth::user()->rol == "Administrador") {

            // $chatbotReq = $request->chatbot;

            // dd($request);

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
        
        // $this->validate($request, [
        //     'name' => 'required',
        //     'description' => 'required',
        //     'approach' => 'required',
        // ]);

        // $data = $request->all();

        // $chatbot= Chatbot::find($id);
        // $chatbot->update($data);

        // return redirect()->route('chatbot.index')->with('success','Chatbot updated successfully');


        if (Auth::user()->rol == "Administrador") {
            $chatbot = Chatbot::find($id);
            if($chatbot) {
                $this->processForm($request, $chatbot);
                return redirect()->route('chatbot.index')->with('success','Chatbot updated successfully');
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
        $chatbot=  Chatbot::find($id);

        $chatbot->delete();

        //store status message

        // return redirect()->route('chatbot.index')->withSuccess(trans('app.success_store'));
        return redirect()->route('chatbot.index')->with('success','Chatbot deleted successfully');
    }

    private function processForm(Request $request, $chatbot) {
        $chat = $request->chatbot;
        // $data['user_id'] = Auth::user()->id;

        // if(!array_key_exists('public', $data))
        //     $data['public'] = false;

        // dd($data);
        $chatbot->fill($chat);
        $chatbot->save();

        /*Probar vincunlar micro contenido al usuario*/
        // $exist = DB::table('micro_content_user')->where(array('micro_content_user.micro_content_id'=> $chatbot->id, 'micro_content_user.user_id' => Auth::user()->id))->get();
        // if(sizeof($exist)==0){
        //     DB::table('micro_content_user')->insert(
        //         [
        //             'micro_content_id' => $chatbot->id,
        //             'user_id' => Auth::user()->id
        //         ]
        //     );
        // }

        /******************************************* */

        //Sincronizo las relaciones (many to many)
        // $chatbot->topics()->sync($request->topic);
        // $chatbot->actions()->sync($request->action);

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

        //Elimino todas las paginas
        // $chatbot->pages()->delete();

        // $pages = $request->page;
        // $images_array = [];

        //Para que DOM lea HTML 5
        // libxml_use_internal_errors(true);
        // if($pages) {
        //     foreach ($pages as $page) {
        //         $document = new \DOMDocument();
        //         $newPage = new Page();
        //         try {
        //             $document->loadHTML($page['content']);
        //             $document->encoding = 'utf-8';
        //             $images = $document->getElementsByTagName('img');
        //             foreach ($images as $image) {
        //                 if ($image->hasAttributes()) {
        //                     $scrAttr = $this->findDOMNodeAttr($image, 'src');
        //                     $fileNameAttr = $this->findDOMNodeAttr($image, 'data-filename');
        //                     if ($scrAttr) {
        //                         $src = $scrAttr->value;
        //                         $isImage = true;
        //                         $imageUrl = $src;
        //                         if (preg_match('/^data:image\/(\w+);base64,/', $src, $type)) {
        //                             $src = substr($src, strpos($src, ',') + 1);
        //                             $type = strtolower($type[1]); // jpg, png, gif

        //                             if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
        //                                 break;
        //                             }

        //                             $imageFile = base64_decode($src);
        //                             if ($imageFile !== false) {
        //                                 $imageName = uniqid() . '.jpg';

        //                                 if($fileNameAttr) {
        //                                     $fileNameAttr->value = '';
        //                                 }

        //                                 $fileName = "uploads/img/" . $imageName;
        //                                 file_put_contents($fileName, $imageFile);
        //                                 $scrAttr->value = '/' . $fileName;

        //                                 $imageUrl = $fileName;
        //                             }
        //                             else{
        //                                 $isImage = false;
        //                             }
        //                         }

        //                         if($isImage) {
        //                             $image = new Image();
        //                             $image->url = $imageUrl;
        //                             $images_array[] = $image;
        //                         }
        //                     }
        //                 }
        //             }

        //         } catch (\Exception $e) {
        //             echo $e->getMessage();
        //         }
        //         finally {
        //             $data = $page;
        //             $html = $document->saveHTML();
        //             $body = '';
        //             if (preg_match('/(?:<body[^>]*>)(.*)<\/body>/isU', $html, $matches)) {
        //                 $body = $matches[1];
        //             }
        //             $data['content'] = $body;
        //             $data['micro_content_id'] = $chatbot->id;
        //             $newPage->fill($data);
        //             $newPage = Page::create($data);

        //             foreach ($images_array as $key => $image) {
        //                 //$image->entity_id = $newPage->id;
        //                 $newPage->images()->save($image);
        //                 //$image->save();
        //             }

        //             $images_array = [];
        //         }
        //     }
        // }

        $questions = $request->question;
        $mCQuestions = $chatbot->questions;
        // dd($chatbot->questions);
        $questionCount = count($mCQuestions);
        if($questions) {
            foreach ($questions as $qKey => $data) {
                $data['chatbot_id'] = $chatbot->id;
                // dd($data);
                if($qKey < $questionCount) {
                    $question = $mCQuestions[$qKey];
                    $question->update($data);
                }
                else{
                    $question = QuestionChatbot::create($data);
                }

                $qAnswers = $question->answers;
                $answerCount = count($qAnswers);
                // $correct_index = $data['is_correct'];
                // dd($data['answers']);
                foreach ($data['answers'] as $key => $answerData) {
                    // dd($answerData);
                    $answerData['question_chatbot_id'] = $question->id;
                    // $answerData['is_correct'] = $key == $correct_index;
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
