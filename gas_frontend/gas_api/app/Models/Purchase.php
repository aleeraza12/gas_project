<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['date','receipt_number','receipt_attachment_path','company_name','company_phone_name','driver_name','gas_quantity','amount','unit_price','user_id','payment_status_id','status'];
}
