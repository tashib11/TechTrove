<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
 protected $fillable=[
    'total',
    'discount',
        'vat',
            'payable',
            'cus_details',//customer_profile theke just niye ashbo
            'ship_details',
            'shipping-method',
            'tran_id',
            'delivery_status',
            'payment_status',

            'user_id'
 ];
}
