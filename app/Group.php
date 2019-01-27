<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function configurations(){
        return $this->belongsToMany(ActionPlanConfiguration::class);
    }
}
