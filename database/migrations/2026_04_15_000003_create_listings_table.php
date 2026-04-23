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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title', 140);
            $table->text('description');
            $table->string('status', 16)->default('draft');
            $table->string('property_type', 32);
            $table->string('space_type', 32);
            $table->unsignedInteger('monthly_rent_centavos');
            $table->unsignedInteger('deposit_centavos')->nullable();
            $table->date('available_from');
            $table->unsignedTinyInteger('minimum_stay_months')->nullable();
            $table->boolean('furnished')->default(false);
            $table->boolean('utilities_included')->default(false);
            $table->unsignedTinyInteger('available_slots')->default(1);
            $table->unsignedTinyInteger('current_occupants')->nullable();
            $table->string('region', 120);
            $table->string('province', 120);
            $table->string('city_municipality', 120);
            $table->string('district_or_barangay', 120)->nullable();
            $table->string('address_private')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('allows_smoking')->nullable();
            $table->boolean('allows_pets')->nullable();
            $table->string('preferred_tenant_gender', 32)->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('property_type');
            $table->index('city_municipality');
            $table->index('available_from');
            $table->index('monthly_rent_centavos');
            $table->index(['status', 'city_municipality', 'property_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
