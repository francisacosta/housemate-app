<?php

namespace Database\Factories;

use App\Models\RoommatePost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RoommatePost>
 */
class RoommatePostFactory extends Factory
{
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

        $budgetMin = fake()->numberBetween(500000, 1400000);
        $budgetMax = $budgetMin + fake()->numberBetween(200000, 700000);

        return [
            'user_id' => User::factory(),
            'title' => fake()->randomElement([
                'Looking for one calm roommate to split a condo search',
                'Open to joining a tidy flatshare near transit',
                'Trying to form a two-to-three person apartment group',
                'Searching for a quiet room and respectful housemates',
            ]),
            'description' => fake()->randomElement([
                'I am planning a move within the next few weeks and want a practical shared setup with people who value calm routines, clear communication, and clean common areas.',
                'I do not have a unit yet, but I already know my target area and budget. I would like to connect with people who want to search together and move with a realistic timeline.',
                'I am open to either joining an existing place or forming a small group first before renting. I care most about cleanliness, reliability, and a respectful shared-living setup.',
            ]),
            'status' => 'draft',
            'post_type' => fake()->randomElement(['looking_for_place', 'looking_for_roommates', 'forming_group']),
            'budget_min_centavos' => $budgetMin,
            'budget_max_centavos' => $budgetMax,
            'move_in_date' => fake()->dateTimeBetween('+1 week', '+3 months'),
            'preferred_property_type' => fake()->randomElement(['apartment', 'condo', 'house', 'bedspace']),
            'region' => $region,
            'province' => $province,
            'city_municipality' => $city,
            'district_or_barangay' => $district,
            'roommate_intent' => fake()->randomElement(['looking_for_room', 'looking_for_roommates', 'either']),
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
}
