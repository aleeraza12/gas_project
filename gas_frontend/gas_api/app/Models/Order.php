<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'gas_quantity', 'order_id', 'amount', 'customer_id', 'user_id', 'payment_mode_id', 'payment_status_id','unit_price','status'
    ];

    public function payment_mode(){
        return $this->hasOne(PaymentMode::class);
    }

    public function payment_status(){
        return $this->hasOne(PaymentStatus::class);
    }
}
