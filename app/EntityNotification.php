<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntityNotification extends Model
{
    protected $table = 'entity_notifications';

    protected $primaryKey = 'id';

    protected $fillable = [
        'entity_id',
        'entity_type',
        'notification_id',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function entity() {
        return $this->morphTo();
    }

    public function notification() {
        return $this->belongsTo(Notification::class);
    }
}
