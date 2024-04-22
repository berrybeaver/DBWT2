<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $table = 'ab_article';

    protected $fillable = ['id', 'ab_name', 'ab_description', 'ab_createdate'];

    public function getImagePath($id)
    {
        $jpgImagePath = "img/{$id}.jpg";
        $pngImagePath = "img/{$id}.png";

        $imagePath = public_path($jpgImagePath);

        if(file_exists($imagePath)){
            return asset( $jpgImagePath);
        } else {
            $imagePath = public_path( $pngImagePath);

            if(file_exists($imagePath)){
                return asset($pngImagePath);
            }
        }

        return asset("/img/default.png");
    }

}
