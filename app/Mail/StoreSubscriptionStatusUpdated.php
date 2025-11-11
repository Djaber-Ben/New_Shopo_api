<?php

namespace App\Mail;

use App\Models\Store;
use App\Models\StoreSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StoreSubscriptionStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $store;
    public $subscription;
    public $vendor;

    /**
     * Create a new message instance.
     */
    public function __construct($store, $subscription, $vendor)
    {
        $this->store = $store;
        $this->subscription = $subscription;
        $this->vendor = $vendor;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Store Subscription Has Been Updated')
                    ->view('emails.store_subscription_status_updated');
    }
}