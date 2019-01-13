<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreeContent extends Model
{
    protected $table = 'free_contents';

    protected $primaryKey = 'id';

    protected $fillable = [
        'content',
        'action_plan_id',
        'action_plan_order',
        'title'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected static function boot() {
        parent::boot();
        static::deleting(function($freeContent) {
            $freeContent->images->each(function($image) {
                if(file_exists($image->url))
                    unlink($image->url);

                $image->destroy();
            });
        });
    }

    public function actionPlan(){
        return $this->belongsTo(ActionPlan::class);
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'entity');
    }
}
