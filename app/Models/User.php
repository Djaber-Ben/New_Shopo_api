<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Store;
use App\Models\Wishlist;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'user_type',
    'logo',
    'image',
    'phone_number',
    'address',
  ];

  public function wishlist()
  {
    return $this->hasMany(Wishlist::class);
  }

  public function store()
  {
    return $this->hasOne(Store::class, 'vendor_id');
  }

  public function clientConversations()
  {
    return $this->hasMany(Conversation::class, 'client_id');
  }

  public function vendorConversations()
  {
    return $this->hasMany(Conversation::class, 'vendor_id');
  }

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }
}
