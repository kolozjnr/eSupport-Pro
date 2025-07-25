<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Customer;
use App\Notifications\SubscriptionExpired;
use App\Notifications\SubscriptionExpiring;
use Illuminate\Support\Facades\Notification;

class CheckSubscription
{
    public function handle($request, Closure $next)
    {
        // Get all users with active subscriptions
        $users = Customer::where('is_subscribed', 1)->get();
        
        foreach ($users as $user) {
            $today = Carbon::now();
            $dueDate = Carbon::parse($user->subscription_due_date);
            
            // Calculate remaining days
            $remainingDays = $today->diffInDays($dueDate, false);
            
            // Check if subscription is in grace period (20 hours past due)
            if ($remainingDays < 0 && $today->diffInHours($dueDate) <= 20) {
                // Still in grace period, no action needed
                continue;
            }
            
            // Handle expired subscriptions (after grace period)
            if ($remainingDays < 0 && $today->diffInHours($dueDate) > 20) {
                $user->update([
                    'is_subscribed' => 0,
                    'general_support_points' => 0,
                    'call_service_points' => 0,
                    'virtual_assistance_points' => 0
                ]);
                
                // Send expiration notification
                $user->notify(new SubscriptionExpired());
                continue;
            }
            
            // Send notifications for upcoming expiration
            $this->sendExpirationNotifications($user, $remainingDays);
        }
        
        return $next($request);
    }
    
    protected function sendExpirationNotifications($user, $remainingDays)
    {
        $notificationDays = [10, 8, 5, 2, 1];
        
        if (in_array($remainingDays, $notificationDays)) {
            $user->notify(new SubscriptionExpiring($remainingDays));
        }
    }
}