<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['product_type_id', 'creative_id', 'user_id'];

    protected $appends = ['product_type'];

    /**
     * Get the vendor that owns the product.
     */
    public function vendor()
    {
        return $this->belongsTo(Product::class);
    }

    public function getProductTypeAttribute()
    {
        return ProductType::find($this->product_type_id)->name;
    }

    /**
     * Get the product type.
     */
    public function type()
    {
        return $this->belongsTo(ProductType::class);
    }

    /**
     * Get the product creative.
     */
    public function creative()
    {
        return $this->belongsTo(Creative::class);
    }
}
