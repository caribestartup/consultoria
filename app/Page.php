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

    public function quitar_tildes($cadena) {
        $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
        $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
        $texto = str_replace($no_permitidas, $permitidas ,$cadena);
        return $texto;
    }

    public function titleSlug() {
        return strtolower(str_replace(' ', '-', $this->quitar_tildes($this->title)));
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
