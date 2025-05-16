<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CustomerProfile extends Model
{
    protected $fillable = [
        'cus_name',
        'cus_add',
        'cus_city',
        'cus_state',
        'cus_country',
        'cus_phone',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
