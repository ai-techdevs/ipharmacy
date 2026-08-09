<?php
namespace App\Utils;


use App\Models\Setting;

class Helper{

    public static function getSetting($name)
    {
        $items = Setting::all() ;
        $settings = [] ;
        foreach ($items as $i => $row) {
            $settings[$row->key] = $row->value ;
        }

        return $settings[$name]  ?? ""  ;

    }
}
