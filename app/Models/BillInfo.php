<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillInfo extends Model
{
      use HasFactory;

    protected $table = 'bill_store_info';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'product_id',
        'bill_store_id',
        'count',  
    ];
}
