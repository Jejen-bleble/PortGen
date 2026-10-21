<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioSection extends Model
{
    protected $fillable = [
        'portfolio_id',
        'section_type',
        'content',
        'order',
    ];

    protected $casts = [
        'content' => 'array', // Automatically converts JSON column to a PHP array
    ];

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}