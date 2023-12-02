<?php

namespace App\Models;

class Transaction extends BaseModel
{
    protected $casts = [
        'query1' => 'json'
    ];

    protected $appends = ['final_amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCompleted($q)
    {
        $q->where("status", "completed");
    }

    // public function getQuery1Attribute($value)
    // {
    //     $data = json_decode($value, true);

    //     $data['image'] = asset($data['image']);

    //     return $data;
    // }

    public function getFinalAmountAttribute()
    {
        return $this->amount + $this->charge - $this->discount_amount;
    }
}
