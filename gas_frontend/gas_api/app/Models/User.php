<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone_number',
        'password',
        'designation',
        'status',
        'last_login_at',
        'permissions',
        'user_type_id'
    ];
    public function user_type(){
        return $this->hasOne(UserType::class);
    }

    
    public function setPermissionsAttribute($value)
    {
        $this->attributes['permissions'] = serialize($value);
    }
    public function getPermissonsAttribute($value)
    {
        return unserialize($value);
    }
}


