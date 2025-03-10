<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipPoin extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'transaction_id',
        'poin_earned',
        'poin_redeemed',
        'balance',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
