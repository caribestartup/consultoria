<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'actions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'objectives',
        'objectives_percent',
        'action_plan_id',
        'action_plan_order'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function actionPlan() {
        return $this->belongsTo(ActionPlan::class);
    }

    public function configurations() {
        return $this->hasMany(ActionConfiguration::class);
    }
    
    public function microContents()
    {
        return $this->belongsToMany(MicroContent::class);
    }

    public function questions() {
        return $this->hasMany(PlanQuestion::class);
    }
}
