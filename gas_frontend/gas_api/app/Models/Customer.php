<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone_number',
        'status',
        'city',
        'state',
        'customer_type',
        'address',
        'company_id'
    ];
    public function customer_type()
    {
        return $this->hasOne(CustomerType::class);
    }
    public function company()
    {
        return $this->hasOne(Company::class);
    }
    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}
