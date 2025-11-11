<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $fillable = [
        'product_id', 
        'image', 
        'is_primary'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
