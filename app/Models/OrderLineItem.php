<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLineItem extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden
        = [
            'product_id',
            'vendor_id',
            'order_id',
            'created_at',
            'updated_at'
        ];
}
