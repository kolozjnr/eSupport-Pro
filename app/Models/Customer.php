<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function review()
    {
        return $this->hasMany(Rating::class);
    }

    public function subscription()
    {
        return $this->hasMany(subscription::class);
    }

   protected static function booted()
    {
        static::creating(function ($customer) {
            do {
                $uniqueId = 'customer-' . strtoupper(Str::random(8));
            } while (Customer::where('unique_id', $uniqueId)->exists());

            $customer->unique_id = $uniqueId;
        });
    }

}
