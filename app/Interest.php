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
        'reminders_value',
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

    public function hasTopic($id)
    {
        $found = false;
        $array = $this->topics;
        $i = 0;
        while(!$found && ($i < sizeof($array))){
            if($id == $array[$i]->id){
                $found = true;
            }
            $i++;
        }
        return $found;
    }
}
