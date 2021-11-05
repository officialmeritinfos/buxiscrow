<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositMethods extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='deposit_methods';
}
