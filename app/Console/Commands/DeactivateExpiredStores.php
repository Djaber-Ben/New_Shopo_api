<?php

namespace App\Console\Commands;

use App\Models\Store;
use App\Models\StoreSubscription;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\OfflinePayment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeactivateExpiredStores extends Command
{
    protected $signature = 'stores:deactivate-expired';
    protected $description = 'Deactivate stores with expired subscriptions and notify vendors';

    public function handle()
    {
        $now = Carbon::now();

        try {
            Store::where('status', 'active')
                ->whereNotNull('subscription_expires_at')
                ->where('subscription_expires_at', '<', $now)
                ->chunk(100, function ($stores) use ($now) {
                    foreach ($stores as $store) {
                        // Update store status
                        $store->update(['status' => 'inactive']);

                        // Update corresponding subscription
                        $subscription = StoreSubscription::where('store_id', $store->id)
                            ->where('status', 'active')
                            ->whereNotNull('end_date')
                            ->where('end_date', '<', $now)
                            ->first();

                        if ($subscription) {
                            $subscription->update(['status' => 'expired']);

                            // Notify vendor
                            $admin = \App\Models\User::where('user_type', 'admin')->first();
                            if ($admin) {
                                $conversation = Conversation::firstOrCreate([
                                    'client_id' => $store->vendor_id,
                                    'vendor_id' => $admin->id,
                                    'store_id' => $store->id,
                                ]);

                                $adminPayment = OfflinePayment::first();
                                $paymentDetails = $adminPayment
                                    ? "Please send payment to: CCP Number: {$adminPayment->ccp_number}, Cle: {$adminPayment->cle}, Rip: {$adminPayment->rip}, Name: {$adminPayment->name} {$adminPayment->family_name}, Address: {$adminPayment->address}"
                                    : "Contact admin for payment details.";

                                Message::create([
                                    'conversation_id' => $conversation->id,
                                    'sender_id' => $admin->id,
                                    'message' => "Your store '{$store->store_name}' subscription has expired. {$paymentDetails} to renew.",
                                ]);
                            }
                        }
                    }
                });

            $this->info('Expired subscriptions deactivated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to deactivate expired stores: ' . $e->getMessage());
            $this->error('An error occurred while deactivating expired stores.');
        }
    }
}