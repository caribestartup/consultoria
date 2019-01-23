<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ActionPlanConfiguration extends Model
{
    protected $table = 'action_plan_configurations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'has_coach',
        'coach_functions',
        'public',
        'tracing',
        'reminders',
        'reminders_period',
        'reminders_value',
        'user_id',
        'action_plan_id',
        'coach_id',
        'start_date',
        'ending_date'
    ];

    public function actionPlan(){
        return $this->belongsTo(ActionPlan::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function collaborators(){
        return $this->hasMany(User::class);
    }

    public function actionConfigurations() {
        return $this->hasMany(ActionConfiguration::class);
    }

    public function trainingsAmount(){
        $actions = $this->actionPlan->actions;
        $amount = 0;
        foreach ($actions as $action){
            $amount += $action->questions->count();
        }

        return $amount;
    }

    public function coach() {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function completedPercent(){
        $result = 0;
        foreach ($this->actionConfigurations as $action){
            $result += $action->completedPercent();
        }

        return $result;
    }

    public function endingDate(){
        return Carbon::parse($this->ending_date);
    }

    public function startDate(){
        return Carbon::parse($this->start_date);
    }

    public function remindersValue(){
        $result = $this->reminders_value;
        if($this->reminders_period == 0)
            $result = date('H:i', $this->reminders_value);

        return $result;
    }


}
