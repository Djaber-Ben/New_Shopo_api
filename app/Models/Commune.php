<?php

namespace App\Models;

use App\Models\Wilaya;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commune extends Model
{
    use HasFactory;

    protected $fillable = [
        'wilaya_id',
        'code',
        'name_en',
        'name_ar',
    ];

    public function wilaya()
    {
        return $this->belongsTo(Wilaya::class);
    }
}
