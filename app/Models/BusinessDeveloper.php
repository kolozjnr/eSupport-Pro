<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class BusinessDeveloper extends Model
{
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function referrals()
    {
        return $this->hasMany(Customer::class, 'business_developer_id');
    }



    public static function generateRefCode()
    {
        return Cache::remember('last_referral_code', now()->addHour(), function () {
            do {
                $code = str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
            } while (self::where('referral_code', $code)->exists());

            return $code;
        });
    }

    /**
     * Track a new successful referral
     */
    public function trackReferral($referralData = [])
    {
        $this->increment('referral_count');
        $this->last_referral_at = now();
        $this->save();

        return $this->referrals()->create(array_merge(
            ['joined_at' => now()],
            $referralData
        ));
    }

    /**
     * Get referral link (accessor)
     */
    public function getReferralLinkAttribute()
    {
        return route('referral.show', ['code' => $this->referral_code]);
    }

    /**
     * Get successful referrals count (with caching)
     */
    public function getSuccessfulReferralsCount()
    {
        return Cache::remember(
            "business_dev_{$this->id}_referrals_count",
            now()->addDay(),
            fn() => $this->referrals()->count()
        );
    }
}
