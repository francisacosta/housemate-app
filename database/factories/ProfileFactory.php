<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        [$region, $province, $city, $district] = fake()->randomElement([
            ['National Capital Region', 'Metro Manila', 'Quezon City', 'Diliman'],
            ['National Capital Region', 'Metro Manila', 'Makati', 'Poblacion'],
            ['National Capital Region', 'Metro Manila', 'Taguig', 'Fort Bonifacio'],
            ['Region IV-A', 'Laguna', 'Santa Rosa', 'Balibago'],
            ['Region VII', 'Cebu', 'Cebu City', 'Lahug'],
            ['Region XI', 'Davao del Sur', 'Davao City', 'Buhangin'],
        ]);

        $budgetMin = fake()->numberBetween(500000, 1800000);
        $budgetMax = $budgetMin + fake()->numberBetween(200000, 700000);

        return [
            'user_id' => User::factory(),
            'display_name' => fake()->name(),
            'avatar_path' => null,
            'headline' => fake()->randomElement([
                'Remote worker looking for a tidy flatshare.',
                'Easygoing tenant who values quiet evenings.',
                'Clean and respectful roommate open to city living.',
                'Early-riser looking for a practical shared setup.',
            ]),
            'bio' => fake()->paragraph(3),
            'occupation' => fake()->randomElement([
                'Software Engineer',
                'Marketing Associate',
                'Customer Support Specialist',
                'Nurse',
                'Graphic Designer',
                'Accountant',
            ]),
            'work_setup' => fake()->randomElement(['remote', 'hybrid', 'onsite']),
            'age_bracket' => fake()->randomElement(['18_24', '25_30', '31_35', '36_45']),
            'gender_identity' => fake()->randomElement(['woman', 'man', 'non_binary', 'prefer_not_to_say']),
            'budget_min_centavos' => $budgetMin,
            'budget_max_centavos' => $budgetMax,
            'move_in_date' => fake()->dateTimeBetween('+1 week', '+3 months'),
            'region' => $region,
            'province' => $province,
            'city_municipality' => $city,
            'district_or_barangay' => $district,
            'roommate_intent' => fake()->randomElement(['looking_for_room', 'looking_for_roommates', 'either']),
            'preferred_property_type' => fake()->randomElement(['apartment', 'condo', 'house', 'bedspace']),
            'visibility_status' => 'draft',
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'visibility_status' => 'published',
            'published_at' => now(),
        ]);
    }
}
