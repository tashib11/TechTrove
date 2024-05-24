<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static where(string $string, mixed $id)
 */
class Product extends Model
{
    protected $fillable = [
        'title',
        'short_des',
        'discount_price',
        'discount',
        'price',
        'image',
        'brand_id',
        'category_id',
        'remark',
        'stock',
        'star'
    ];

 

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
