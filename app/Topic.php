<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';

    protected $primaryKey = 'id';

    protected $fillable = [
        'value'
    ];

    public function interests()
    {
        return $this->belongsToMany(Interest::class);
    }

    public function microContent()
    {
        return $this->belongsToMany(MicroContent::class);
    }

    public function actionPlans()
    {
        return $this->belongsToMany(ActionPlan::class);
    }

    protected $hidden = ['created_at', 'updated_at'];
}
