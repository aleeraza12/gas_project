<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Promos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable  = ['promo_name', 'promo_percentage', 'company_id'];
    public function getCreatedAtAttribute($value)
    {

        $date = Carbon::parse($value)->addHours(5);
        return $date->isoFormat('dddd,Do MMMM YYYY');
    }
}
