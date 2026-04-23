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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('display_name');
            $table->string('avatar_path')->nullable();
            $table->string('headline', 120)->nullable();
            $table->text('bio')->nullable();
            $table->string('occupation')->nullable();
            $table->string('work_setup', 32)->nullable();
            $table->string('age_bracket', 24)->nullable();
            $table->string('gender_identity', 32)->nullable();
            $table->unsignedInteger('budget_min_centavos')->nullable();
            $table->unsignedInteger('budget_max_centavos')->nullable();
            $table->date('move_in_date')->nullable();
            $table->string('region', 120);
            $table->string('province', 120);
            $table->string('city_municipality', 120);
            $table->string('district_or_barangay', 120)->nullable();
            $table->string('roommate_intent', 32)->default('either');
            $table->string('preferred_property_type', 32)->nullable();
            $table->string('visibility_status', 16)->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('visibility_status');
            $table->index('city_municipality');
            $table->index('move_in_date');
            $table->index('roommate_intent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
