<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanAnswer extends Model
{
    protected $table = 'plan_answers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
        'plan_question_id',
        'action_configuration_id',
        'user_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function planQuestion() {
        return $this->belongsTo(PlanQuestion::class);
    }

    public function actionConfiguration() {
        return $this->belongsTo(ActionConfiguration::class);
    }
}
