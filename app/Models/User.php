<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends AuthenticatableBaseModel
{
    use HasRoles, HasUuids, SoftDeletes;

    protected $guard_name = 'api';


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'wallet_balance' => 'decimal:2',
        'is_verified' => 'bool',
        'push_notification' => 'bool',
        'sms_notification' => 'bool',
        'email_notification' => 'bool'
    ];


    public function getProfileImageAttribute($value)
    {
        return asset($value);
    }
}
