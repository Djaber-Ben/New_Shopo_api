<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfflinePayment extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name', 'family_name', 'ccp_number', 'cle', 'rip', 'address'
    ];
}
