<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'gas_quantity', 'total_amount',  'discount_code', 'customer_name', 'customer_type', 'payment_mode', 'status', 'company_id', 'price', 'customer_phone_number'
    ];
}
