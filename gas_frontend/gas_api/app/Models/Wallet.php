<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable = ['transaction_id', 'account_name', 'account_number', 'amount', 'status', 'authorized_by'];
    public function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value)->addHours(1);
        return $date->toDayDateTimeString();
    }
    public function getAmountAttribute($value)
    {
        return intval($value);
    }
}
