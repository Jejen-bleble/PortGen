<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
    ];

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }
}