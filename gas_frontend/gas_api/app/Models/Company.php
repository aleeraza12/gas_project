<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['owner_name', 'company_email', 'company_name', 'company_phone_number', 'address', 'city', 'state', 'gas_plant_type', 'password', 'company_profile_picture'];


    public function token()
    {
        return $this->hasOne(Token::class);
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
}
