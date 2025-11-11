<?php

namespace App\Models;

use App\Models\Store;
use App\Models\OfflinePayment;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StoreSubscription extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'store_id', 'subscription_plan_id', 'payment_receipt_image', 'start_date', 'end_date', 'status'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where('end_date', '>=', now());
    }
}
