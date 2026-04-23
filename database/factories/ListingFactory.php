<?php

namespace Database\Factories;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Listing>
 */
class ListingFactory extends Factory
{
    protected $model = Listing::class;

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

        $propertyType = fake()->randomElement(['apartment', 'condo', 'house', 'bedspace']);
        $spaceType = fake()->randomElement(['private_room', 'shared_room', 'entire_unit']);
        $rent = fake()->numberBetween(700000, 2500000);

        return [
            'user_id' => User::factory(),
            'title' => fake()->randomElement([
                'Open room in a clean and quiet unit',
                'Condo share near business district',
                'Budget-friendly bedspace with flexible move-in',
                'Private room in a furnished house',
            ]),
            'description' => fake()->paragraphs(3, true),
            'status' => 'draft',
            'property_type' => $propertyType,
            'space_type' => $spaceType,
            'monthly_rent_centavos' => $rent,
            'deposit_centavos' => fake()->boolean(70) ? fake()->numberBetween(0, $rent * 2) : null,
            'available_from' => fake()->dateTimeBetween('+1 day', '+2 months'),
            'minimum_stay_months' => fake()->boolean(75) ? fake()->numberBetween(1, 12) : null,
            'furnished' => fake()->boolean(70),
            'utilities_included' => fake()->boolean(40),
            'available_slots' => fake()->numberBetween(1, 3),
            'current_occupants' => fake()->boolean(75) ? fake()->numberBetween(0, 4) : null,
            'region' => $region,
            'province' => $province,
            'city_municipality' => $city,
            'district_or_barangay' => $district,
            'address_private' => fake()->streetAddress(),
            'latitude' => fake()->randomFloat(7, 6.9, 14.7),
            'longitude' => fake()->randomFloat(7, 120.8, 125.2),
            'allows_smoking' => fake()->optional()->boolean(),
            'allows_pets' => fake()->optional()->boolean(),
            'preferred_tenant_gender' => fake()->randomElement(['women_only', 'men_only', 'any']),
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'published_at' => now(),
        ]);
    }
}
