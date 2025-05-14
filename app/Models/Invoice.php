<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'shipping_name',
        'shipping_phone',
        'shipping_alt_phone',
        'shipping_city',
        'shipping_division',
        'shipping_address',
        'gift_wrap',
        'shipping_fee',
        'total',
        'tran_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function products()
{
    return $this->hasMany(InvoiceProduct::class, 'invoice_id')->with('product');
}


}
