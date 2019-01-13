<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionChatbot extends Model
{
    protected $table = 'question_chatbot';

    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
    ];

    protected $hidden = ['created_at', 'updated_at'];


    public function chatBot()
    {
        return $this->belongsTo(Chatbot::class);
    }

    public function answerChatbot()
    {
        return $this->hasMany(AnswerChatbot::class);
    }

}
