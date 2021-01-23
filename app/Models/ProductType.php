<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    /**
     * Get the products fo this type
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the vendor for this product_type
     */
    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }
}
