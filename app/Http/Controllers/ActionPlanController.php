<?php

namespace App\Http\Controllers;

use App\Action;
use App\ActionConfiguration;
use App\ActionPlan;
use App\ActionPlanConfiguration;
use App\FreeContent;
use App\Image;
use App\MicroContent;
use App\Notification;
use App\PlanAnswer;
use App\PlanQuestion;
use App\UserMicroContent;
use App\PlanQuestionOption;
use App\Question;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ActionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $actionPConfigs = null;

        if (Auth::user()->rol == "Administrador" ||  Auth::user()->rol == "Jefe") {
            $actionPConfigs = ActionPlanConfiguration::paginate(15);
        }
        else {
            $actionPConfigs = ActionPlanConfiguration::join('action_plan_configuration_user', 'action_plan_configuration_user.action_plan_configuration_id', '=', 'action_plan_configurations.id')
                                ->where('action_plan_configuration_user.user_id', Auth::user()->id)
                                ->select('action_plan_configurations.id',
                                        'action_plan_configurations.has_coach',
                                        'action_plan_configurations.coach_functions',
                                        'action_plan_configurations.public',
                                        'action_plan_configurations.tracing',
                                        'action_plan_configurations.reminders',
                                        'action_plan_configurations.reminders_period',
                                        'action_plan_configurations.reminders_value',
                                        'action_plan_configurations.user_id',
                                        'action_plan_configurations.action_plan_id',
                                        'action_plan_configurations.coach_id',
                                        'action_plan_configurations.start_date',
                                        'action_plan_configurations.ending_date')
                                ->paginate(15);

            // $actionPConfigs = ActionPlanConfiguration::find($microContents1->id)->simplePaginate(1);
        }
        return view('action_plan.index', ['actionPConfigs' => $actionPConfigs]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_coach()
    {

        $actionPConfigs = ActionPlanConfiguration::where('action_plan_configurations.coach_id', Auth::user()->id)
                            ->paginate(15);

        return view('action_plan.index', ['actionPConfigs' => $actionPConfigs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->rol == "Administrador" || Auth::user()->rol == "Jefe") {
            $microContents = MicroContent::all();
            return view('action_plan.create', compact('microContents'));
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

        if (Auth::user()->rol == "Administrador" || Auth::user()->rol == "Jefe") {

            $actions = $request->action;

            $actionPConfig = $this->processForm($request, $actionPlan = new ActionPlan());
            return redirect(action('TrainingController@show', ['id' => $actionPConfig->id]));
        }
        else {
            return view('error.403');
        }
    }

    private function processForm(Request $request, $actionPlan, $configuration = null)
    {
        $data = $request->plan;
        $actionPlan->fill($data);
        $actionPlan->save();

        //Elimino las preguntas
        $toRemove = $request->deleted['questions'];
        $toRemove = explode(',', $toRemove);
        if(count($toRemove))
            PlanQuestion::destroy($toRemove);

        //Elimino las acciones
        $toRemove = $request->deleted['actions'];
        $toRemove = explode(',', $toRemove);
        if(count($toRemove))
            Action::destroy($toRemove);

        //Elimino las acciones
        $toRemove = $request->deleted['answers'];
        $toRemove = explode(',', $toRemove);
        if(count($toRemove))
            PlanQuestionOption::destroy($toRemove);

        if($configuration == null)
            $configuration = new ActionPlanConfiguration();

        $configuration->fill($request->configuration);

        $configuration->user_id = Auth::user()->id;
        $configuration->action_plan_id = $actionPlan->id;
        if($actionPlan->type == ActionPlan::GUIDED) {
            if (array_key_exists('reminders', $request->configuration)) {
                //Convierto la hora a tiempo
                if ($request->configuration['reminders_period'] == ActionPlan::R_DAILY) {
                    $configuration->reminders_value = \DateTime::createFromFormat('H:i',
                        $configuration->reminders_value)->getTimestamp();
                }
            } else {
                $configuration->reminders = null;
                $configuration->reminders_value = null;
                $configuration->reminders_period = null;
            }

            //Elimino las preguntas y contenidos libres asociados
            // Esto es para en caso que sea editando y haya cambiado de tipo de plan
            $actionPlan->questions()->delete();
            $actionPlan->freeContents()->delete();
        }

        if(!array_key_exists('has_coach', $request->configuration)) {
            $configuration->coach_id = $configuration->coach_functions = null;
            $configuration->has_coach = false;
        }

        $configuration->save();

        //Sinconizar grupos de usuario
        $userInsert = array();

        if(isset($request->groups)) {

            foreach ($request->groups as $group) {

                $insertGroup = DB::table('action_plan_configuration_group')->where(
                    array(
                        'action_plan_configuration_id' => $configuration->id,
                        'group_id' => $group
                    )
                    )->get();

                    if($insertGroup->isEmpty()) {
                        DB::table('action_plan_configuration_group')->insert(
                            [
                                'action_plan_configuration_id' => $configuration->id,
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

        if(isset($request->users)) {

            foreach ($request->users as $user) {
                array_push($userInsert, $user);
            }
        }

        $resultado = array_unique($userInsert);

        //Sincronizo los usuarios
        $configuration->users()->sync($resultado);

        $actions = $request->action;
        $pActionConfigs = $configuration->actionConfigurations;
        $actionConfigCount = count($pActionConfigs);
        if($actions) {
            foreach ($actions as $key => $data) {
                $data['action_plan_id'] = $actionPlan->id;
                $data['configuration']['action_plan_configuration_id'] = $configuration->id;

                if(!array_key_exists('collaboration', $data['configuration']))
                    $data['configuration']['collaboration'] = false;

                if($key < $actionConfigCount) {
                    $action = $pActionConfigs[$key]->action;
                    $action->update($data);

                    $actionConfiguration = $pActionConfigs[$key];
                }
                else{
                    $action = Action::create($data);
                    $actionConfiguration = new ActionConfiguration();
                    $action->configurations->push($actionConfiguration);
                }

                $microContents = [];
                if(array_key_exists('micro_content', $data)) {
                    $microContents = $data['micro_content'];
                }

                $action->microContents()->sync($microContents);

                $data['configuration']['action_id'] = $action->id;

                if($actionPlan->type == ActionPlan::FREE)
                    $action->action_plan_order = $data['order'];

                $actionConfiguration->fill($data['configuration']);
                $actionConfiguration->save();

                $action->update();
                if(array_key_exists('question', $data)) {
                    $questions = $data['question'];
                    $pQuestions = $action->questions;
                    $questionCount = count($pQuestions);
                    if ($questions) {
                        foreach ($questions as $qkey => $data) {
                            $data['action_id'] = $action->id;

                            if ($qkey < $questionCount) {
                                $question = $pQuestions[$qkey];
                                $question->update($data);
                            } else {
                                $question = PlanQuestion::create($data);
                            }

                            if ($question->type != 2) {
                                $qOptions = $question->options;
                                $optionCount = count($qOptions);
                                foreach ($data['options'] as $key => $optionData) {
                                    $optionData['plan_question_id'] = $question->id;
                                    if ($key < $optionCount) {
                                        $option = $qOptions[$key];
                                        $option->update($optionData);
                                        $option->update($optionData);
                                    } else {
                                        PlanQuestionOption::create($optionData);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if($actionPlan->type == ActionPlan::FREE) {
            //Preguntas
            $questions = $request->question;
            $pQuestions = $actionPlan->questions;
            $questionCount = count($pQuestions);
            if ($questions) {
                foreach ($questions as $qkey => $data) {
                    $data['action_plan_id'] = $actionPlan->id;
                    if ($qkey < $questionCount) {
                        $question = $pQuestions[$qkey];
                        $question->update($data);
                    } else {
                        $question = PlanQuestion::create($data);
                    }

                    $question->action_plan_order = $data['order'];
                    $question->update();

                    $qOptions = $question->options;
                    $optionCount = count($qOptions);
                    foreach ($data['options'] as $key => $optionData) {
                        $optionData['plan_question_id'] = $question->id;
                        if ($key < $optionCount) {
                            $option = $qOptions[$key];
                            $option->update($optionData);
                        } else {
                            PlanQuestionOption::create($optionData);
                        }
                    }
                }
            }

            //Contenido libre
            $actionPlan->freeContents()->delete();
            $freeContents = $request->freeContent;
            $images_array = [];
            if($freeContents) {
                foreach ($freeContents as $fkey => $freeContent) {
                    $document = new \DOMDocument();
                    try {
                        $document->loadHTML($freeContent['content']);
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

                    } catch (\Exception $e)
                    {
                        echo $e->getMessage();
                    }
                    finally {
                        $data = $freeContent;
                        $data['content'] = $document->saveHTML();
                        $data['action_plan_id'] = $actionPlan->id;
                        $data['action_plan_order'] = $data['order'];
                        $newFreeContent = FreeContent::create($data);

                        foreach ($images_array as $key => $image) {
                            $newFreeContent->images()->save($image);
                        }

                        $images_array = [];
                    }
                }
            }
        }

        $actions = $request->action;
        //Envio notificaciones
        foreach ($configuration->users as $user) {
            $notification = new Notification();
            $notification->user_id = $user->id;
            $notification->entity_id = $configuration->id;
            $notification->entity_type = ActionPlanConfiguration::class;
            $notification->type = Notification::NEW;
            $notification->save();

            if($actions) {
                foreach ($actions as $key => $data) {

                    $microContents = [];
                    if(array_key_exists('micro_content', $data)) {
                        $microContents = $data['micro_content'];
                    }

                    for ($i=0; $i < sizeof($microContents) ; $i++) {
                        $exist = DB::table('micro_content_user')->where(array('micro_content_id' => $microContents[$i], 'user_id' => $user->id))->first();

                        if (!$exist) {

                            DB::table('micro_content_user')->insert(
                                [
                                    'micro_content_id' => $microContents[$i],
                                    'user_id' => $user->id
                                ]
                            );
                        }
                    }
                    // $user->microContents()->sync($microContents);
                }
            }
        }
        return $configuration;
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actionPConfig = ActionPlanConfiguration::find($id);
        if (isset($actionPConfig)) {
        // if(sizeof($actionPConfig->get()) > 0){
            if (Auth::user()->rol == "Jefe" || Auth::user()->rol == "Administrador" || $actionPConfig->coach_id == Auth::user()->id) {
                return view('action_plan.assigned.assigned', compact('actionPConfig'));
            }
            else {
                return view('error.403');
            }
        }
        else {
            return view('error.404');
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
        if (Auth::user()->rol == "Administrador" || Auth::user()->rol == "Jefe") {
            $actionPConfig = ActionPlanConfiguration::find($id);
            if($actionPConfig) {
                $microContents = MicroContent::all();
                return view('action_plan.create', compact('actionPConfig', 'microContents'));
            }else
                return view('error.404');
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
        if (Auth::user()->rol == "Administrador" || Auth::user()->rol == "Jefe") {
            $configuration = ActionPlanConfiguration::find($id);
            if($configuration) {
                $this->processForm($request, $configuration->actionPlan, $configuration);
                return redirect(action('ActionPlanController@index'));
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
        // dd($id);
        if (Auth::user()->rol == "Administrador") {
            $configuration = ActionPlanConfiguration::find($id);
            if(isset($configuration)) {
                // dd($configuration);
                $actionPlan = $configuration->actionPlan;
                $configuration->delete();
                if ($actionPlan->configurations()->count() == 0) {
                    $actionPlan->delete();
                }
                Notification::where(array('entity_id' => $id, 'entity_type' => 'App\ActionPlanConfiguration'))->delete();
                return redirect(action('ActionPlanController@index'));
            }
            else
                return view('error.404');
        }
        else {
            return view('error.403');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateAssigned(Request $request, $id)
    {
        $actionPConfig = ActionPlanConfiguration::find($id);
        if($actionPConfig && $actionPConfig->users()->where('user_id', Auth::user()->id)->get()->first() != null) {
            $actions = $request->action;
            foreach ($actions as $actionId => $action) {
                $actionConfig = ActionConfiguration::find($actionId);
                $actionConfig->fill($action);
                $actionConfig->save();
                $questions = $action['question'];
                foreach ($questions as $questionId => $question) {
                    $questionO = $actionConfig->action->questions()->where('id', $questionId)->get()->first();
                    if($questionO) {
                        PlanAnswer::where('user_id', Auth::user()->id)
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
                                            PlanAnswer::create([
                                                'plan_question_id' => $questionId,
                                                'action_configuration_id' => $actionId,
                                                'value' => $questionOption->id,
                                                'user_id'   => Auth::user()->id
                                            ]);
                                        }
                                    }
                                }else{
                                    $questionOption = PlanQuestionOption::where('id', $question['value'])->first();
                                    if ($questionOption) {
                                        PlanAnswer::create([
                                            'plan_question_id' => $questionId,
                                            'action_configuration_id' => $actionId,
                                            'value' => $question['value'],
                                            'user_id'   => Auth::user()->id
                                        ]);
                                    }
                                }
                            }
                        }
                        else{
                            PlanAnswer::create([
                                'plan_question_id' => $questionId,
                                'action_configuration_id' => $actionId,
                                'value' => $question['value'],
                                'user_id'   => Auth::user()->id
                            ]);
                        }
                    }
                }
            }
        }
        else
            abort(404);

        return redirect(action('ActionPlanController@index'));
    }
}
