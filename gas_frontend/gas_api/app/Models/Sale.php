<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'gas_quantity', 'total_amount',  'discount_code', 'customer_id', 'customer_type', 'payment_mode', 'status', 'company_id', 'price', 'customer_phone_number'
    ];
    public function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value)->addHours(5);
        return $date->isoFormat('Do MMMM YYYY, h:mm a');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
