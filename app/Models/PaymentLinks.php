<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLinks extends Model
{
    use HasFactory;
    protected $table ='business_payment_link';
    protected $guarded=[];
}
