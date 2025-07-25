<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Notifications\SubscriptionExpired;
use App\Notifications\SubscriptionExpiring;

class CheckSubscriptions extends Command
{
    protected $signature = 'subscriptions:check';
    protected $description = 'Check user subscriptions and send notifications';

    public function handle()
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
                Log::info("User {$user->id} in grace period");
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
                
                
                Log::info("User {$user->id} subscription expired");
                $user->notify(new SubscriptionExpired());
                continue;
            }
            
            // Send notifications for upcoming expiration
            $this->sendExpirationNotifications($user, $remainingDays);
        }
        
        $this->info('Subscription check completed successfully');
    }
    
    protected function sendExpirationNotifications($user, $remainingDays)
    {
        $notificationDays = [10, 8, 5, 2, 1];
        
        if (in_array($remainingDays, $notificationDays)) {
            Log::info("Notifying user {$user->id} about subscription ending in {$remainingDays} days");
            $user->notify(new SubscriptionExpiring($remainingDays));
        }
    }
}