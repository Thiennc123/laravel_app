<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'product_id',
        'id_type',
        'wPrice',
        'rPrice',
        'count',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'id_type');
    }


    public function bill_store()
    {
        return $this->belongsToMany(BillStore::class, 'bill_store_info', 'product_id', 'bill_store_id')->withPivot('count', 'id'); // product_idla khoa ngoai trong bang pivot cua model tao ra lien ket
    }                                                                                                  // bill_store_id la khoa ngoai trong bang pivot cua model duoc lien ket
}
