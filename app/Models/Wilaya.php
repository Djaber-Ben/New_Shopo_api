<?php

namespace App\Models;

use App\Models\Commune;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wilaya extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'number',
        'name_en',
        'name_ar',
    ];

    public function communes()
    {
        return $this->hasMany(Commune::class);
    }
}
