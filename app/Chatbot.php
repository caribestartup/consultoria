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

    function interactions()
    {
        return DB::table('chatbot_design')->where('chatbot_id', '=', $this->id)->count();
    }

    public function firstQuestion()
    {
        $first = null;

        foreach ($this->questions as $question) {

            $exist = QuestionChatbot::join("chatbot_design", "chatbot_design.question_id", "=", "chatbot_questions.id")->where('chatbot_design.question_id', '=', $question->id)->get();
            if(!$exist->isEmpty()){
                $first = $question;
                break;
            }
        }
        return $first;
    }
}
