<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
 protected $fillable=[
    'total',
        'vat',
            'payable',
            'cus_details',//customer_profile theke just niye ashbo
            'ship_details',
            'shipping-method',
            'tran_id',
            'val_id',
            'delivery_status',
            'payment_stat',

            'user_id'
 ];
}
