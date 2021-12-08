<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendMoney extends Model
{
    use HasFactory;
    protected $table='send_money';
    protected $guarded=[];
}
