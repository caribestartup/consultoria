<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
        'is_correct',
        'question_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'answer_user_question');
    }

}
