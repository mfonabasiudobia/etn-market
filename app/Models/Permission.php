<?php

namespace App\Models;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends SpatiePermission
{

    use HasFactory, HasUuids;

    public $guard_name = 'api';

    protected $primaryKey = "id";
    protected $keyType = 'string';
    public $incrementing = false;
    
}
