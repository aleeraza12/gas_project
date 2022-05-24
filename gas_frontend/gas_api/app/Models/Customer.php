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
        'password',
        'status',
        'city',
        'state',
        'customer_type_id',
        'address',
    ];
    public function customer_type(){
        return $this->hasOne(CustomerType::class);
    }


}