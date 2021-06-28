<?php

namespace App\Helper;
use App;
class GlobalHelper
{
    static public function getRespectiveLanguage($fr, $ar){
       $locale = App::getLocale() ? App::getLocale() : 'fr';
       if($locale == 'fr')
            return $fr;
        return $ar;
    }
}