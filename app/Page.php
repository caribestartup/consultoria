<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Page extends Model
{
    protected $table = 'pages';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'content',
        'micro_content_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected static function boot() {
        parent::boot();

        static::deleting(function($page) {
            $page->images->each(function($image) {
                if(file_exists($image->url))
                    unlink($image->url);

                $image->destroy();
            });

        });
    }

    public function microContent()
    {
        return $this->belongsTo(MicroContent::class);
    }

    public function images()
    {
        return $this->morphMany('App\Image', 'entity');
    }

    public function titleSlug() {
        return strtolower(str_replace(' ', '-', $this->title));
    }

    public function littleTitle() {
        $title = $this->title;
        if( strlen($this->title) > 13) {
            $newTitle = '';
            $titleArray = explode(' ', $title);
            $i = 0;
            do {
                $newTitle .= $titleArray[$i++] . ' ';
            }while(strlen($newTitle) <= 13);

            $newTitle .= '...';
            $title = $newTitle;
        }

        return $title;
    }
}
