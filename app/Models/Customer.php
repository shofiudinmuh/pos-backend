<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'membership_poin',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function membershipPoin()
    {
        return $this->hasOne(Membership::class);
    }
}
