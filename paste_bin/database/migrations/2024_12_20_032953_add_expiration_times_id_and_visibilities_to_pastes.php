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
        Schema::table('pastes', function (Blueprint $table) {
            $table->foreignId('visibility_id')->nullable()->constrained('visibilities');
            $table->foreignId('expiration_time_id')->nullable()->constrained('expiration_times');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pastes');
    }
};
