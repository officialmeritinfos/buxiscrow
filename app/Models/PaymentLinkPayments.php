<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLinkPayments extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='business_payment_link_payments';
}
