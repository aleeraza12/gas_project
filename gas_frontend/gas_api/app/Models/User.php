<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'created_by',
        'password',
        'designation',
        'user_type',
        'permissions',
        'status',
        'company_id',
        'user_id',
        'last_login_at'
    ];
    public function user_type()
    {
        return $this->hasOne(UserType::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }


    public function setPermissionsAttribute($value)
    {
        $this->attributes['permissions'] = serialize($value);
    }
    public function getPermissionsAttribute($value)
    {
        return unserialize($value);
    }
}
