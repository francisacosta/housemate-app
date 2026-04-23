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
        Schema::create('profile_preferences', function (Blueprint $table) {
            $table->foreignId('profile_id')->primary()->constrained()->cascadeOnDelete();
            $table->string('cleanliness_level', 24)->nullable();
            $table->string('smoking_preference', 24)->nullable();
            $table->string('drinking_preference', 24)->nullable();
            $table->string('pet_preference', 24)->nullable();
            $table->string('sleep_schedule', 24)->nullable();
            $table->string('guest_policy', 24)->nullable();
            $table->string('noise_tolerance', 24)->nullable();
            $table->string('cooking_habit', 24)->nullable();
            $table->string('work_schedule', 24)->nullable();
            $table->boolean('can_share_room')->nullable();
            $table->string('preferred_housemate_gender', 32)->nullable();
            $table->unsignedTinyInteger('max_housemates_preference')->nullable();
            $table->text('dealbreakers_text')->nullable();
            $table->text('household_rules_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_preferences');
    }
};
