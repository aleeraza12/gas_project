<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'receipt_number', 'receipt_attachment_path', 'company_name', 'company_phone_number', 'driver_name', 'gas_quantity', 'amount', 'unit_price', 'company_id', 'recepient_name', 'paid', 'paid_at', 'unpaid', 'unpaid_at', 'delivered', 'delivered_at'
];

    //public function getDateAttribute($value)
    //{
    //    $date = Carbon::parse($value);
    //    return $date->isoFormat('Do MMMM YYYY, h:mm a');
    //}
}
