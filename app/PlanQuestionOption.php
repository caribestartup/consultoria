<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanQuestionOption extends Model
{
    protected $table = 'plan_question_options';

    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
        'plan_question_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function planQuestion() {
        return $this->belongsTo(PlanQuestion::class);
    }
}
