<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessApiPayment extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='business_api_payments';
}
