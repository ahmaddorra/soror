<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $appends = ['action'];
    protected $casts = ['location' => 'array'];

    public function getActionAttribute()
    {
        return "";
    }
}
