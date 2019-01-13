<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
