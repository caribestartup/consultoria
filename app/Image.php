<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $primaryKey = 'id';

    protected $fillable = [
        'url',
        'entity_id',
        'entity_type'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function entity()
    {
        return $this->morphTo();
    }
}
