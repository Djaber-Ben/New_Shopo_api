<?php

namespace App\Models;

use App\Models\StoreSubscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionPlan extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name', 'description', 'price', 'duration_days', 'is_trial', 'status'
    ];

    public function storeSubscriptions()
    {
        return $this->hasMany(StoreSubscription::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}