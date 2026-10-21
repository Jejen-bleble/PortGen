<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            if (!Schema::hasColumn('portfolios', 'experience')) {
                $table->text('experience')->nullable();
            }
            if (!Schema::hasColumn('portfolios', 'github')) {
                $table->string('github')->nullable();
            }
            if (!Schema::hasColumn('portfolios', 'linkedin')) {
                $table->string('linkedin')->nullable();
            }
            if (!Schema::hasColumn('portfolios', 'twitter')) {
                $table->string('twitter')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['experience', 'github', 'linkedin', 'twitter']);
        });
    }
};