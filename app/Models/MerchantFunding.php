<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantFunding extends Model
{
    use HasFactory;
    protected $table='merchant_funding';
    protected $guarded=[];
}
