<?php

namespace App\Http\Controllers;

use App\Action;
use App\ActionPlan;
use App\ActionPlanConfiguration;
use App\Answer;
use App\Image;
use App\MicroContent;
use App\Page;
use App\Question;
use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MicroContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $microContents = MicroContent::paginate(15);
        return view('micro_content.index', ['microContents' => $microContents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $topics = Topic::all(['id', 'value']);
        $actionPlans = ActionPlan::all(['id', 'title']);
        return view('micro_content.create', compact('topics', 'actionPlans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$request->validate([
             'micro_content.title' => 'required|max:5',
             'micro_content.public' => 'boolean',
             'micro_content.type' => 'nullable',
         ]);
            */

        $this->processForm($request, $microContent = new MicroContent());
        return redirect(action('MicroContentController@show', ['id' => $microContent->id]));
    }

    private function findDOMNodeAttr($node, $name) {
        $result = null;
        foreach ($node->attributes as $attribute) {
            if($attribute->name == $name) {
                $result = $attribute;
                break;
            }
        }

        return $result;
    }

    public function ajaxActionPlans(Request $request) {
        return DB::table('action_plans')
            ->join('action_plan_configurations', 'action_plans.id', '=', 'action_plan_configurations.action_plan_id')
            ->join('users', 'users.id', '=', 'action_plan_configurations.user_id')
            ->where('users.id', $request->user)
            ->get(['action_plans.id', 'action_plans.title']);
    }

    public function ajaxActions(Request $request) {
        return Action::where('action_plan_id', $request->action_plan)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $microContent = MicroContent::find($id);
        if($microContent)
            return view('micro_content.show', ['microContent' => $microContent ]);
        else
            abort(404);
    }

    public function evaluate(Request $request) {
        $data = $request->question;
        $user_id = Auth::user()->id;
        $microContentId = Question::find(array_keys($data)[0])->microContent->id;
        $microContent = MicroContent::find($microContentId);
        $result = 'failure';
        if($microContent->id) {
            if ($microContent->userCanAnswer(Auth::user())) {
                foreach ($data as $question_id => $answer_id) {
                    DB::table('answer_user_question')->insert(
                        compact('question_id', 'answer_id', 'user_id')
                    );
                }

               // $result = 'success';
            }

            $result1 = DB::table('micro_contents')
            ->join('questions', 'micro_contents.id', '=', 'questions.micro_content_id')
            ->join('answers', 'questions.id', '=', 'answers.question_id')
            ->join('answer_user_question', 'answers.id', '=', 'answer_user_question.answer_id')
            ->where('answers.is_correct', true)
            ->where('micro_contents.id', $microContent->id)
            ->distinct()
            ->sum('questions.points');

            $total = DB::table('micro_contents')
            ->join('questions', 'micro_contents.id', '=', 'questions.micro_content_id')
            ->where('micro_contents.id', $microContent->id)
            ->sum('questions.points');

            

            $result = 'Tu resultado es: '.$result1.' de '.$total.' y el aprovado minimo es: '.$microContent->approve;
        }

        return ['state' => $result];
    }

    private function processForm(Request $request, $microContent) {
        $data = $request->micro_content;
        $data['user_id'] = Auth::user()->id;

        if(!array_key_exists('public', $data))
            $data['public'] = false;

        $microContent->fill($data);
        $microContent->save();

        //Sincronizo las relaciones (many to many)
        $microContent->topics()->sync($request->topic);
        $microContent->actions()->sync($request->action);

        //Envio notificaciones a los usuarios con esas acciones


        //Elimino las preguntas y respuestas a eliminar
        $toRemoveQuestions = $request->deleted['questions'];
        $toRemoveQuestions = explode(',', $toRemoveQuestions);
        if(count($toRemoveQuestions))
            Question::destroy($toRemoveQuestions);

        $toRemoveAnswers = $request->deleted['answers'];
        $toRemoveAnswers = explode(',', $toRemoveAnswers);
        if(count($toRemoveAnswers))
            Answer::destroy($toRemoveAnswers);

        //Elimino todas las paginas
        $microContent->pages()->delete();

        $pages = $request->page;
        $images_array = [];

        //Para que DOM lea HTML 5
        libxml_use_internal_errors(true);
        if($pages) {
            foreach ($pages as $page) {
                $document = new \DOMDocument();
                $newPage = new Page();
                try {
                    $document->loadHTML($page['content']);
                    $document->encoding = 'utf-8';
                    $images = $document->getElementsByTagName('img');
                    foreach ($images as $image) {
                        if ($image->hasAttributes()) {
                            $scrAttr = $this->findDOMNodeAttr($image, 'src');
                            $fileNameAttr = $this->findDOMNodeAttr($image, 'data-filename');
                            if ($scrAttr) {
                                $src = $scrAttr->value;
                                $isImage = true;
                                $imageUrl = $src;
                                if (preg_match('/^data:image\/(\w+);base64,/', $src, $type)) {
                                    $src = substr($src, strpos($src, ',') + 1);
                                    $type = strtolower($type[1]); // jpg, png, gif

                                    if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                                        break;
                                    }

                                    $imageFile = base64_decode($src);
                                    if ($imageFile !== false) {
                                        $imageName = uniqid() . '.jpg';

                                        if($fileNameAttr) {
                                            $fileNameAttr->value = '';
                                        }

                                        $fileName = "uploads/img/" . $imageName;
                                        file_put_contents($fileName, $imageFile);
                                        $scrAttr->value = '/' . $fileName;

                                        $imageUrl = $fileName;
                                    }
                                    else{
                                        $isImage = false;
                                    }
                                }

                                if($isImage) {
                                    $image = new Image();
                                    $image->url = $imageUrl;
                                    $images_array[] = $image;
                                }
                            }
                        }
                    }

                } catch (\Exception $e) {
                    echo $e->getMessage();
                }
                finally {
                    $data = $page;
                    $html = $document->saveHTML();
                    $body = '';
                    if (preg_match('/(?:<body[^>]*>)(.*)<\/body>/isU', $html, $matches)) {
                        $body = $matches[1];
                    }
                    $data['content'] = $body;
                    $data['micro_content_id'] = $microContent->id;
                    $newPage->fill($data);
                    $newPage = Page::create($data);

                    foreach ($images_array as $key => $image) {
                        //$image->entity_id = $newPage->id;
                        $newPage->images()->save($image);
                        //$image->save();
                    }

                    $images_array = [];
                }
            }
        }

        $questions = $request->question;
        $mCQuestions = $microContent->questions;
        $questionCount = count($mCQuestions);
        if($questions) {
            foreach ($questions as $qKey => $data) {
                $data['micro_content_id'] = $microContent->id;
                if($qKey < $questionCount) {
                    $question = $mCQuestions[$qKey];
                    $question->update($data);
                }
                else{
                    $question = Question::create($data);
                }

                $qAnswers = $question->answers;
                $answerCount = count($qAnswers);
                $correct_index = $data['is_correct'];
                foreach ($data['answers'] as $key => $answerData) {
                    $answerData['question_id'] = $question->id;
                    $answerData['is_correct'] = $key == $correct_index;
                    if($key < $answerCount) {
                        $answer = $qAnswers[$key];
                        $answer->update($answerData);
                    }else{
                        Answer::create($answerData);
                    }
                }
            }
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
        $microContent = MicroContent::find($id);
        if($microContent) {
            $topics = Topic::all();
            $actionPlans = ActionPlan::all(['id', 'title']);
            return view('micro_content.create', compact('microContent', 'topics', 'actionPlans'));
        }
        else {
            abort(404);
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
        $microContent = MicroContent::find($id);

        if($microContent) {
            $this->processForm($request, $microContent);
            return redirect(action('MicroContentController@show', ['id' => $microContent->id]));
        }
        else
            abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $microContent = MicroContent::find($id);
        $microContent->pages()->each(function ($page) {
            $page->delete();
        });

        $microContent->delete();

        return redirect(action('MicroContentController@index'));
    }
}
