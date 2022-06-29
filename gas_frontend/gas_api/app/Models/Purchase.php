<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'receipt_number', 'receipt_attachment_path', 'company_name', 'company_phone_number', 'driver_name', 'gas_quantity', 'amount','logistics_cost','admin_cost', 'unit_price', 'company_id', 'recepient_name', 'paid', 'user_id', 'paid_at', 'unpaid', 'unpaid_at', 'delivered', 'delivered_at'
    ];
}
