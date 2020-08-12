<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait OfferTrait {


    protected function saveImages($photo, $folder) {

         $file_extension = $photo->getClientOriginalExtension();
         $file_name 	 = time() . '.' . $file_extension;
         $path           = $folder;
         $photo->move($path, $file_name);

         return $file_name;
    }

}
    
