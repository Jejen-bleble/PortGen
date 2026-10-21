<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_sections', function (Blueprint $table) {
            if (!Schema::hasColumn('portfolio_sections', 'portfolio_id')) {
                $table->foreignId('portfolio_id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('portfolio_sections', 'section_type')) {
                $table->string('section_type')->after('portfolio_id');
            }
            if (!Schema::hasColumn('portfolio_sections', 'content')) {
                $table->json('content')->nullable()->after('section_type');
            }
            if (!Schema::hasColumn('portfolio_sections', 'order')) {
                $table->integer('order')->default(0)->after('content');
            }
        });
    }

    public function down(): void
    {
        Schema::table('portfolio_sections', function (Blueprint $table) {
            $table->dropColumn(['section_type', 'content', 'order']);
        });
    }
};
