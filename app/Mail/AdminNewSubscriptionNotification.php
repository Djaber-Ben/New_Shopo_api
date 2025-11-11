<?php

namespace App\Mail;

use App\Models\Store;
use App\Models\StoreSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNewSubscriptionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $store;
    public $subscription;

    /**
     * Create a new message instance.
     */
    public function __construct(Store $store, StoreSubscription $subscription)
    {
        $this->store = $store;
        $this->subscription = $subscription;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Store Subscription Pending Review')
                    ->view('emails.admin_new_subscription_notification');
    }
}
