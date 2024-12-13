<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pastes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->string('title');
            $table->text('content');
            $table->timestamps();
            $table->dateTime('expires_at')->nullable();
            $table->enum('visibility', ['public', 'unlisted', 'private']);
            $table->enum('expiration_time', ['10min', '1hour', '3hours', '1day', '1week', '1month', 'never']);
            $table->foreignId('language_id')->nullable()->constrained('languages');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->string('short_link')->unique();
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
