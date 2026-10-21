<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            if (!Schema::hasColumn('portfolios', 'facebook')) {
                $table->string('facebook')->nullable();
            }
            if (!Schema::hasColumn('portfolios', 'address')) {
                $table->string('address')->nullable();
            }
            if (!Schema::hasColumn('portfolios', 'contact_number')) {
                $table->string('contact_number')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropColumn(['facebook', 'address', 'contact_number']);
        });
    }
};
