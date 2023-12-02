<?php

namespace App\Models;

class Shop extends BaseModel
{
    public function market()
    {
        return $this->belongsTo(Market::class);
    }
}
