<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository  {


    public static function singleUpdate($key, $value) : bool {
        return Setting::where('key', $key)->first()->update([ 'value' => $value ]);
    }


    public static function multipleUpdate($data) : bool {

        foreach ($data as $key => $value) {
            Setting::where('key', $key)->first()->update([ 'value' => $value ]);
        }

        return true;
    }



}
