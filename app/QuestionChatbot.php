<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionChatbot extends Model
{
    protected $table = 'chatbot_questions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
        'chatbot_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];


    public function chatbot()
    {
        return $this->belongsTo(Chatbot::class);
    }

    public function answers()
    {
        return $this->hasMany(AnswerChatbot::class);
    }

}
