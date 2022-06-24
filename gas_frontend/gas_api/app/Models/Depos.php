<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depos extends Model
{
    use HasFactory;
    protected $fillable  = ['depo_name', 'location', 'price_per_twenty_million_ton', 'company_id','added_by_admin'];

    public function getUpdatedAtAttribute($value)
    {
        $date = Carbon::parse($value)->addHours(5);
        return $date->isoFormat('dddd,Do MMMM YYYY');
    }
}
