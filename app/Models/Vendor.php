<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * Get the vendor's products
     */
    public function line_items()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the vendor's product_type
     */
    public function product_type()
    {
        return $this->belongsTo(ProductType::class);
    }
}
