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
use App\PlanQuestionOption;
use App\Question;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actionPConfigs = ActionPlanConfiguration::paginate(15);
        return view('action_plan.index', ['actionPConfigs' => $actionPConfigs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $microContents = MicroContent::all();
        return view('action_plan.create', compact('microContents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $actionPConfig = $this->processForm($request, $actionPlan = new ActionPlan());
        return redirect(action('ActionPlanController@show', ['id' => $actionPConfig->id]));
    }

    private function processForm(Request $request, $actionPlan, $configuration = null)
    {
        $data = $request->plan;
        $actionPlan->fill($data);
        $actionPlan->save();

        /*foreach ($request->all() as $key => $input) {
            echo $key . ': ';
            var_dump($input);
            echo '<br/>';
        }
        ;die;*/

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

        //Sincronizo los usuarios
        $configuration->users()->sync($request->users);

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

        //Envio notificaciones
        foreach ($configuration->users as $user) {
            $notification = new Notification();
            $notification->user_id = $user->id;
            $notification->entity_id = $configuration->id;
            $notification->entity_type = ActionPlanConfiguration::class;
            $notification->type = Notification::NEW;
            $notification->save();
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
        if($actionPConfig)
            return view('action_plan.assigned.assigned', compact('actionPConfig'));
        else
            abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $actionPConfig = ActionPlanConfiguration::find($id);
        if($actionPConfig) {
            $microContents = MicroContent::all();
            return view('action_plan.create', compact('actionPConfig', 'microContents'));
        }else
            abort(404);
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
        $configuration = ActionPlanConfiguration::find($id);
        if($configuration) {
            $this->processForm($request, $configuration->actionPlan, $configuration);
            return redirect(action('ActionPlanController@index'));
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
        $configuration = ActionPlanConfiguration::find($id);
        if($configuration) {
            $actionPlan = $configuration->actionPlan;
            $configuration->delete();
            if ($actionPlan->configurations()->count() == 0)
                $actionPlan->delete();

            return redirect(action('ActionPlanController@index'));
        }
        else
            abort(404);
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
