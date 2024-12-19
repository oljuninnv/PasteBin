<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'provider')) {
                $table->string(column: 'provider')->nullable();
            }
            if (!Schema::hasColumn('users', 'provider_id')) {
                $table->string(column: 'provider_id')->nullable();
            }
            if (!Schema::hasColumn('users', 'provider_token')) {
                $table->string('provider_token')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('provider');
            $table->dropColumn('provider_id');
            $table->dropColumn('provider_token');
        });
    }
};
