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
        'launch'
        // 'user_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];


    public function questions()
    {
        return $this->hasMany(QuestionChatbot::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function groups(){
        return $this->belongsToMany(Group::class);
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
