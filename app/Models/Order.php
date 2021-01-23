<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden
        = [
            'billing_address_id',
            'shipping_address_id',
            'updated_at',
            'user_id'
        ];

    protected $appends = ['billing_address', 'shipping_address'];

    /**
     * Get the order's billing address
     */
    public function billing_address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function getBillingAddressAttribute()
    {
        return Address::find($this->billing_address_id);
    }

    /**
     * Get the order's shipping address
     */
    public function shipping_address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function getShippingAddressAttribute()
    {
        return Address::find($this->shipping_address_id);
    }

    /**
     * Get the order's line items
     */
    public function line_items()
    {
        return $this->hasMany(OrderLineItem::class);
    }

    /**
     * Get the order's user
     */
    public function user()
    {
        return $this->belongsToOne(User::class);
    }
}
