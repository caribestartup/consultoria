<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerChatbot extends Model
{
    protected $table = 'chatbot_answers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
        'is_correct',
        'question_chatbot_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function questions()
    {
        return $this->belongsTo(QuestionChatbot::class);
    }



}
