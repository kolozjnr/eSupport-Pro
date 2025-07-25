<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public static function generateTrx($len = 10)
    {
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $charLen = strlen($chars);

        do{
            $str = "";
            for ($i = 0; $i < $len; $i++) {
                $str .= $chars[rand(0, $charLen - 1)];
            }
        }while(Subscription::where('reference', $str)->exists());

        return $str;
    
    }
}
