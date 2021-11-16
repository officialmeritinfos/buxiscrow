<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscrowDeliveries extends Model
{
    use HasFactory;
    protected $table='escrow_deliveries';
    protected $guarded=[];
}
