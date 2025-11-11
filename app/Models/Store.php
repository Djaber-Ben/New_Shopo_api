<?php

namespace App\Models;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\StoreSubscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    protected $fillable = [
        'vendor_id', 
        'category_id', 
        'store_name', 
        'slug', 
        'description', 
        'logo', 
        'image', 
        'phone_number', 
        'address', 
        'latitude', 
        'longitude', 
        'city', 
        'wilaya',
        'status', 
        'subscription_expires_at',  
        'whatsapp', 
        'facebook', 
        'instagram', 
        'tiktok'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function vendor()
{
    return $this->belongsTo(User::class, 'vendor_id');
}


    public function products()
    {
        return $this->hasMany(Product::class);
    }

  public function subscriptions()
    {
        return $this->hasMany(StoreSubscription::class)->orderByDesc('created_at');
    }

    public function latestSubscription()
    {
        return $this->hasOne(StoreSubscription::class)->latestOfMany();
    }
}
