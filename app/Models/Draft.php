<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Draft extends Model
{
    protected $table = 'drafts';
    protected $guarded = [];

    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
