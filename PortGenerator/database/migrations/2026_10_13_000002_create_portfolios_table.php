<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // <-- Add this line here!
            $table->foreignId('template_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('full_name');
            $table->string('profile_image')->nullable();
            $table->string('headline');
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('accent_color')->default('indigo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};