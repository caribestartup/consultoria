<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatbot extends Model
{
    protected $table = 'chatbot';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
        'automatic',
        'default_response',
        'approach',

    ];

    protected $hidden = ['created_at', 'updated_at'];


    public function questionChatbot()
    {
        return $this->hasMany(QuestionChatbot::class);
    }

}
