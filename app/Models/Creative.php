<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creative extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the creative's author
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the creative's products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
