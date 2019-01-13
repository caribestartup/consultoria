<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionConfiguration extends Model
{
    protected $table = 'action_configurations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'started_date',
        'estimated_fulfillment_date',
        'real_fulfillment_date',
        'current_objectives',
        'action_id',
        'action_plan_configuration_id',
        'start_date',
        'ending_date',
        'collaboration',
        'done_before',
        'knowledge_level',
        'know_what_to_do',
        'know_how_to_improve',
        'improve_knowledge'
    ];

    public function actionPlanConfiguration() {
        return $this->belongsTo(ActionPlanConfiguration::class);
    }

    public function action() {
        return $this->belongsTo(Action::class);
    }

    public function completedPercent(){
        return round((($this->current_objectives/100) * $this->action->objectives_percent),2);
    }
}
