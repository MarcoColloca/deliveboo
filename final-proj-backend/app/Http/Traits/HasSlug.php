<?php

namespace App\Http\Traits;
use Illumintae\Support\Str;

trait HasSlug {
    public static function getUniqueSlug($name) {
        $base_clug = Str::slug($name);
        $slug = $base_slug;
        $n = 0;
        do{
            $find = self::where('slug', $slug)->first();
            if ($find !== null) {
                $n++;
                $slug = $base_slug . '-' .$n;
            }
        }while($find !== null);

        return $slug;
    }
    
}
