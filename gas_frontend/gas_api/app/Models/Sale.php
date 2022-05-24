<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'gas_quantity', 'transaction_id', 'amount', 'customer_id', 'user_id', 'payment_mode_id', 'payment_status_id','discount_code'
    ];

    public function transaction(){
        return $this->hasOne(Transaction::class);
    }
    
}
