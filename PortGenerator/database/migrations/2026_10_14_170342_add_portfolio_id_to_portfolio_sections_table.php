<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('portfolio_sections', function (Blueprint $table) {
            if (!Schema::hasColumn('portfolio_sections', 'portfolio_id')) {
                $table->foreignId('portfolio_id')->constrained()->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('portfolio_sections', function (Blueprint $table) {
            $table->dropForeign(['portfolio_id']);
            $table->dropColumn('portfolio_id');
        });
    }
};
