<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductSlider extends Model
{
 protected $fillable = ['title', 'short_des', 'price', 'image', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
