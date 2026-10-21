<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            if (!Schema::hasColumn('portfolios', 'school')) {
                $table->string('school')->nullable();
            }
            if (!Schema::hasColumn('portfolios', 'degree')) {
                $table->string('degree')->nullable();
            }
            if (!Schema::hasColumn('portfolios', 'years')) {
                $table->string('years')->nullable();
            }
            if (!Schema::hasColumn('portfolios', 'project_title')) {
                $table->string('project_title')->nullable();
            }
            if (!Schema::hasColumn('portfolios', 'project_link')) {
                $table->string('project_link')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['school', 'degree', 'years', 'project_title', 'project_link']);
        });
    }
};