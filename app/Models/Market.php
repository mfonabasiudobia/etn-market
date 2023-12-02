<?php

namespace App\Models;

class Market extends BaseModel
{

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}
