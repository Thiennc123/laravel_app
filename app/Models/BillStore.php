<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillStore extends Model
{

    use HasFactory;

    protected $table = 'bill_stores';

    protected $fillable = [
        'name',
        'status',
        'bill_store_id',
        'total_price',   
    ];

    public function product()
    {
        return $this->belongsToMany(Product::class, 'bill_store_info','bill_store_id','product_id')->withPivot('id', 'count');
    }
}
