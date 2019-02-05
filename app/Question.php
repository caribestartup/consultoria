<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
        'micro_content_id',
        'points'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function microContent()
    {
        return $this->belongsTo(MicroContent::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function userAnswers() {
        return $this->belongsToMany(Answer::class, 'answer_user_question');
    }

    public function userResults(User $user) {
        $answer = $this->userAnswers()->
        where('user_id', $user->id)->get()->last();
        $points = 0;
        if($answer != null && $answer->is_correct)
            $points = $this->points;

        return $points;
    }

    public function userCanAnswer(User $user) {
        return $this->userAnswers()->where('user_id', $user->id)->count() < 1;
    }
}
