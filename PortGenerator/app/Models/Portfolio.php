<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id',
        'template_id',
        'full_name',
        'headline',
        'profile_image',
        'bio',
        'email',
        'address',
        'contact_number',
        'github',
        'linkedin',
        'twitter',
        'facebook',
        'experience',
        'school',        // <-- Added column for school
        'degree',        // <-- Added column for degree
        'years',         // <-- Added column for years
        'project_title', // <-- Added column for project title
        'project_link',  // <-- Added column for project link
        'projects',      // <-- Added column for projects text/description
        'slug',
    ];

    // Removed 'education' and 'projects' from casts since they are now direct scalar columns

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(PortfolioSection::class)->orderBy('order');
    }
}