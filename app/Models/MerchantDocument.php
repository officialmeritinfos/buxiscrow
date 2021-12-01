<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantDocument extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table='merchant_documents';
}
