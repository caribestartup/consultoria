<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function compliment() {
        $rol = Auth::user()->rol;
        $user_id = Auth::user()->id;
        $actionPs = $this->actionPlan();
        $totalPercent = 0;
        foreach ($actionPs->get() as $actionP) {

            $actions = $actionP->actions();

            foreach ($actions->get() as $action) {
                $microContens = $action->microContents();

                $total = sizeof($microContens->get());
                $count = 0;
                foreach ($microContens->get() as $microContent) {
                    
                    $micro = DB::table('micro_content_user')
                    ->join('micro_contents', 'micro_contents.id', '=', 'micro_content_user.micro_content_id')
                    ->where('micro_contents.id', $microContent->id)
                    ->where('micro_content_user.user_id', $user_id)
                    ->where('micro_content_user.approve_coach', true)
                    ->get();

                    if(sizeof($micro) > 0){
                        $count++;
                    }
                }
                if($count == $total){
                    $totalPercent += $action->objectives_percent;
                }
            }

        }
        return $totalPercent;
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
