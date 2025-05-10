<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceProduct extends Model
{
       use HasFactory;

    protected $fillable = [
        'invoice_id',
        'user_id',
        'product_id',
        'qty',
        'price',
        'color',
        'size',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }
    public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}

}
