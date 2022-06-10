<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depos extends Model
{
    use HasFactory;
    protected $fillable  = ['depo_name', 'location', 'price_per_twenty_million_ton', 'company_id'];

    public function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->toDayDateTimeString(); 
    }
}
