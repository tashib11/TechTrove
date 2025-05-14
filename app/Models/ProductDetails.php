<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductDetails extends Model
{
   protected $fillable = [
    'img1', 'img2', 'img3', 'img4',
    'img1_alt', 'img2_alt', 'img3_alt', 'img4_alt',
    'img1_width', 'img1_height',
    'img2_width', 'img2_height',
    'img3_width', 'img3_height',
    'img4_width', 'img4_height',
    'des', 'color', 'size', 'product_id'
];



    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
