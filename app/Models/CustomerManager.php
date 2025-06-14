<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerManager extends Model
{
    protected $quarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
