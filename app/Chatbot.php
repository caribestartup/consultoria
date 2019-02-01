<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Chatbot extends Model
{
    protected $table = 'chatbots';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'approach',
        'launch',
    ];

    protected $hidden = ['created_at', 'updated_at'];


    public function questions()
    {
        return $this->hasMany(QuestionChatbot::class);
    }

    public function guide()
    {
        $questions = $this->questions;

        foreach ($questions->get() as $key => $question) {
            //answer->question
        }
    }

    public function firstQuestion()
    {
        $first;
        // return $this->questions;
        foreach ($this->questions as $question) {
            // return $question;
            $exist = QuestionChatbot::join("chatbot_design", "chatbot_design.question_id", "=", "chatbot_questions.id")->where('chatbot_design.question_id', '=', $question->id)->get();
            if(isset($exist)){
                // return $exist;
                $first = $question;
                break;
            }
        }
        return $first;
    }

}
