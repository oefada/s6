<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden
        = [
            'id',
            'addressable_type',
            'addressable_id',
            'created_at',
            'updated_at'
        ];

    /**
     * Get the parent imageable model (user or post).
     */
    public function addressable()
    {
        return $this->morphTo();
    }
}
