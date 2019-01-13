<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerChatbot extends Model
{
    protected $table = 'answer_chatbot';

    protected $primaryKey = 'id';

    protected $fillable = [
        'value',
        'is_correct'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function questionChatBot()
    {
        return $this->belongsTo(QuestionChatbot::class);
    }



}
