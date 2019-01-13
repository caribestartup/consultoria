<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $table = 'interests';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'importance_level',
        'knowledge_valuation',
        'expiration_date',
        'objectives',
        'public',
        'reminders',
        'reminders_period',
        'user_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }
}
