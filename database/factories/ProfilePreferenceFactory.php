<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\ProfilePreference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProfilePreference>
 */
class ProfilePreferenceFactory extends Factory
{
    protected $model = ProfilePreference::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'profile_id' => Profile::factory(),
            'cleanliness_level' => fake()->randomElement(['relaxed', 'balanced', 'very_clean']),
            'smoking_preference' => fake()->randomElement(['non_smoker', 'outside_only', 'okay']),
            'drinking_preference' => fake()->randomElement(['no', 'social', 'okay']),
            'pet_preference' => fake()->randomElement(['no_pets', 'cats_okay', 'dogs_okay', 'pet_friendly']),
            'sleep_schedule' => fake()->randomElement(['early_bird', 'balanced', 'night_owl']),
            'guest_policy' => fake()->randomElement(['rare', 'moderate', 'okay_with_guests']),
            'noise_tolerance' => fake()->randomElement(['quiet', 'moderate', 'flexible']),
            'cooking_habit' => fake()->randomElement(['rarely', 'sometimes', 'daily']),
            'work_schedule' => fake()->randomElement(['day_shift', 'night_shift', 'rotating', 'flexible']),
            'can_share_room' => fake()->boolean(),
            'preferred_housemate_gender' => fake()->randomElement(['women_only', 'men_only', 'any']),
            'max_housemates_preference' => fake()->numberBetween(1, 5),
            'dealbreakers_text' => fake()->randomElement([
                'Heavy indoor smoking and repeated late rent payments.',
                'Unannounced overnight guests on weekdays.',
                'Shared spaces left dirty for extended periods.',
                null,
            ]),
            'household_rules_text' => fake()->randomElement([
                'Quiet hours after 10 PM and clean-as-you-go in the kitchen.',
                'Split chores weekly and flag guest plans ahead of time.',
                'Label shared food and keep common areas clutter-free.',
            ]),
        ];
    }
}
