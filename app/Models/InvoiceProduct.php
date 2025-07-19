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


    public function product()
{
    return $this->belongsTo(Product::class);
    /*
    Model: Product
Column: product_id ,then no need to explicitly show the foreign key
,because laravel convantion is modelname_id

if the column name was 'prod_id' then
    return $this->belongsTo(Product::class, 'prod_id');
    */


}

}
