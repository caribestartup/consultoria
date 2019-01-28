<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

}
