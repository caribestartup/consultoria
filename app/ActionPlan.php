<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionPlan extends Model
{
    public const GUIDED = 0;
    public const FREE = 1;
    public const INDIVIDUAL = 0;
    public const COLLECTIVE = 1;
    public const R_DAILY = 1;
    public const R_WEEKLY = 2;
    public const R_MONTHLY = 3;

    protected $table = 'action_plans';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'objectives',
        'type',
        'collaboration'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function actions() {
        return $this->hasMany(Action::class);
    }

    public function configurations(){
        return $this->hasMany(ActionPlanConfiguration::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function freeContents(){
        return $this->hasMany(FreeContent::class);
    }

    public function questions(){
        return $this->hasMany(PlanQuestion::class);
    }

    public function freePlanElements() {
        $elements = $this->actions->concat($this->questions)->concat($this->freeContents);
        for($i = 1; $i < count($elements); $i++) {
            for($j = 0; $j < count($elements) - $i; $j++) {
                if($elements[$j]->action_plan_order > $elements[$j+1]->action_plan_order) {
                    $k = $elements[$j+1];
                    $elements[$j+1] = $elements[$j];
                    $elements[$j]=$k;
                }
            }
        }

        return $elements;
    }

}
