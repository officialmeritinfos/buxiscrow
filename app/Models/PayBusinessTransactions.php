<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayBusinessTransactions extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='pay_business_transactions';
}
