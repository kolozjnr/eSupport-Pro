<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Customer;
use App\Notifications\SubscriptionExpired;
use App\Notifications\SubscriptionExpiring;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class CheckSubscriptionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check customer subscriptions and send expiration notifications';

    /**
     * Execute the console command.
     *
     * @return void
     */
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
                $this->info("Subscription expired for user ID: {$user->id}");
                continue;
            }

            // Send notifications for upcoming expiration
            $this->sendExpirationNotifications($user, $remainingDays);
        }

        $this->info('Subscription check completed successfully.');
    }

    /**
     * Send expiration notifications based on remaining days.
     *
     * @param  \App\Models\Customer  $user
     * @param  int  $remainingDays
     * @return void
     */
    protected function sendExpirationNotifications($user, $remainingDays)
    {
        $notificationDays = [10, 8, 5, 2, 1];

        if (in_array($remainingDays, $notificationDays)) {
            $user->notify(new SubscriptionExpiring($remainingDays));
            $this->info("Expiration notification sent to user ID: {$user->id} for {$remainingDays} days remaining");
        }
    }
}