<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicroContent extends Model
{
    protected $table = 'micro_contents';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'approve',
        'public',
        'type',
        'user_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function images() {
        return $this->hasManyThrough(
            Image::class,
            Page::class,
            'micro_content_id',
            'entity_id',
            'id',
            'id');
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function actions()
    {
        return $this->belongsToMany(Action::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userResults(User $user){
        $result = 0;
        foreach ($this->questions as $question) {
            $result += $question->userResults($user);
        };

        return $result;
    }

    public function userCanAnswer(User $user) {
        $result = true;
        foreach ($this->questions as $question) {
            if(!$question->userCanAnswer($user))
                $result = false;
        }

        return $result;
    }
}

