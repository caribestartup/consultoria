<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public const NEW = 'new';
    public const UPDATED = 'update';
    public const REMOVED = 'removed';
    public const LINKED_ACTION_MICROCONTENT = 'linked_action_microcontent';


    protected $table = 'notifications';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'entity_id',
        'entity_type',
        'read',
        'type'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function entity() {
        return $this->morphTo();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function image() {
        $image = $this->user->avatar;
        if($this->entity_type == ActionConfiguration::class
            && $this->type == self::LINKED_ACTION_MICROCONTENT)
            return 'images/micro_contents.svg';
        elseif($this->entity_type == ActionPlanConfiguration::class)
            $image = 'images/action_plan.svg';

        return $image;
    }

    public function message() {
        $message = '';
        if($this->type == self::NEW){
            switch ($this->entity_type) {
                case ActionPlanConfiguration::class :
                    $entityName = trans_choice( 'common.action_plan', 1);
                    break;
                case Interest::class :
                    $entityName = trans_choice( 'common.interest', 1);
                    break;
            }

            // $entityName = strtolower($entityName);
            // $message = __('notification.new_notification_m', ['name' => $entityName]);
            $message = $entityName;
        }

        return $message;
    }

    public function url() {
        $url = array();
        if($this->type == self::NEW){
            switch ($this->entity_type) {
                case ActionPlanConfiguration::class :
                    $url['url'] = action('ActionPlanController@show', ['id' => $this->entity_id]);
                    $fin = ActionPlanConfiguration::find($this->entity_id);

                    $dias = (strtotime($fin->ending_date)-strtotime(date("Y-m-d")))/86400;
                    $dias = abs($dias); $dias = floor($dias);
                    $url['dias'] = $dias;

                    if ($fin->ending_date > date("Y-m-d")) {
                        $url['mgs'] = 'días para el cierre';
                        $url['style'] = '#2EFE2E';
                    } else if ($fin->ending_date == date("Y-m-d")) {
                        $url['mgs'] = 'cierra hoy';
                        $url['style'] = '#FFBF00';
                    } else {
                        $url['mgs'] = 'días de atraso';
                        $url['style'] = '#FF0000';
                    }

                    $url['inicio'] = $fin->start_date;
                    break;
                case Interest::class :
                    $url['url'] = action('InterestController@show', ['id' => $this->entity_id]);
                    break;
            }
        }

        return $url;
    }

    public function entities() {
        return $this->hasMany(EntityNotification::class);
    }

}
