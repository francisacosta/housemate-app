<?php

namespace Database\Factories;

use App\Models\Listing;
use App\Models\ListingPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ListingPhoto>
 */
class ListingPhotoFactory extends Factory
{
    protected $model = ListingPhoto::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'listing_id' => Listing::factory(),
            'storage_path' => 'listing-photos/'.fake()->uuid().'.jpg',
            'sort_order' => 0,
            'is_cover' => false,
        ];
    }
}
