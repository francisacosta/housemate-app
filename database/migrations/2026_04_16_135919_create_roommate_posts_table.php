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
        Schema::create('roommate_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 140);
            $table->text('description');
            $table->string('status', 16)->default('draft');
            $table->string('post_type', 32);
            $table->unsignedInteger('budget_min_centavos')->nullable();
            $table->unsignedInteger('budget_max_centavos')->nullable();
            $table->date('move_in_date')->nullable();
            $table->string('preferred_property_type', 32)->nullable();
            $table->string('region', 120);
            $table->string('province', 120);
            $table->string('city_municipality', 120);
            $table->string('district_or_barangay', 120)->nullable();
            $table->string('roommate_intent', 32)->default('either');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('post_type');
            $table->index('city_municipality');
            $table->index('move_in_date');
            $table->index('preferred_property_type');
            $table->index(['status', 'city_municipality', 'post_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roommate_posts');
    }
};
