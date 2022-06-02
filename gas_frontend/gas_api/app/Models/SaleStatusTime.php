<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleStatusTime extends Model
{
    use HasFactory;
    protected $fillable = ['status', 'status_time', 'sale_id'];
}
