<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    protected $table = 'departments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }
}
