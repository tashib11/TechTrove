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
        'img_alt',
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
    public function productDetails(): HasOne
{
    return $this->hasOne(ProductDetails::class);
}
public function slider()
{
    return $this->hasOne(ProductSlider::class);
}

}
