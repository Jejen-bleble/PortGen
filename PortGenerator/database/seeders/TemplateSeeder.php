<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        Template::create([
            'name' => 'Simple',
            'slug' => 'simple',
            'description' => 'A lightweight, single-column layout focused on fast readability, clean typography, and essential contact links.',
            'thumbnail' => 'templates/simple.png',
        ]);

        Template::create([
            'name' => 'Modern',
            'slug' => 'modern',
            'description' => 'A contemporary grid layout with sleek hero cards, accent colors, and polished hover states for showcase projects.',
            'thumbnail' => 'templates/modern.png',
        ]);

        Template::create([
            'name' => 'Creative',
            'slug' => 'creative',
            'description' => 'A bold, expressive aesthetic featuring unique visual hierarchy, vibrant highlights, and smooth badge tags.',
            'thumbnail' => 'templates/creative.png',
        ]);
    }
}