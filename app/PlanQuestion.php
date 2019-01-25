<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlanQuestion extends Model
{
    public const SINGLE = 0;
    public const MULTIPLE = 1;
    public const FREE_TEXT = 2;

    protected $table = 'plan_questions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'action_id',
        'action_plan_id',
        'action_plan_order',
        'type'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function action() {
        return $this->belongsTo(Action::class);
    }

    public function options() {
        return $this->hasMany(PlanQuestionOption::class);
    }

    public function answers() {
        return $this->hasMany(PlanAnswer::class);
    }

    public function actionPlan(){
        return $this->belongsTo(ActionPlan::class);
    }

    public function userAnswered($userId, $questionId, $answerValue = '') {
        if($answerValue != '')
            return $this->answers()
                ->where('user_id', $userId)
                ->where('plan_question_id', $questionId)
                ->where('value', $answerValue)
                ->get();
        else
            return $this->answers()
                ->where('user_id', $userId)
                ->where('plan_question_id', $questionId)
                ->get();
    }

    public function answer () {

        $answers = DB::table('plan_answer_training')
            ->join('plan_question_options', 'plan_answer_training.value', '=', 'plan_question_options.id')
            ->where('plan_question_options.plan_question_id', $this->id)
            ->select(
                    'plan_answer_training.created_at',
                    'plan_question_options.value',
                    'plan_answer_training.email')
            ->get();

        return $answers;
            
    }
}
