<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount', 'gas_quantity', 'type', 'outer_id', 'company_id'
    ];
    public function getUpdatedAtAttribute($value)
    {
        $date = Carbon::parse($value)->addHours(5);
        return $date->isoFormat('Do MMMM YYYY, h:mm a');
    }
}
