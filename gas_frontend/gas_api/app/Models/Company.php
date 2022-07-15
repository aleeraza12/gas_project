<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['owner_name', 'company_email', 'company_name', 'status', 'company_phone_number', 'address', 'city', 'state', 'password',   'permissions', 'company_profile_picture', 'is_super_admin'];

    public function getIsSuperAdminAttribute($value)
    {
        return $value == "0" || $value == 0 ? false : true;
    }

    public function getCompanyProfilePictureAttribute($value)
    {
        if ($value != null) {
            return base64_encode(Storage::get($value));
        }
        return null;
    }

    public function setPermissionsAttribute($value)
    {
        $this->attributes['permissions'] = serialize($value);
    }

    public function getPermissionsAttribute($value)
    {
        return unserialize($value);
    }

    public function token()
    {
        return $this->hasMany(Token::class);
    }

    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }
    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
    public function customer()
    {
        return $this->hasMany(Customer::class);
    }
    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function customer_type()
    {
        return $this->hasMany(CustomerType::class);
    }
    public function payment_mode()
    {
        return $this->hasMany(PaymentMode::class);
    }
    public function user_type()
    {
        return $this->hasMany(UserType::class);
    }
    public function states()
    {
        return $this->hasMany(States::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function depos()
    {
        return $this->hasMany(Depos::class);
    }

    public function promos()
    {
        return $this->hasMany(Promos::class);
    }
}
